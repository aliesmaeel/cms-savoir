<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchBayutProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:bayutproperties';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import properties from the local Bayut XML feed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');
        $startedAt = microtime(true);

        $this->info('Bayut import pipeline started at ' . now()->toDateTimeString());
        Log::channel('fetching_properties')->alert('Bayut pipeline start: regenerating XML from PropertyFinder');

        // Step 1: regenerate the XML feed from PropertyFinder.
        $this->newLine();
        $this->line('<fg=cyan>[1/3] Regenerating XML from PropertyFinder...</>');
        try {
            app()->call('App\Http\Controllers\PropertyXmlController@generateXml');
            $this->info('      XML feed regenerated.');
        } catch (\Throwable $th) {
            $this->warn('      XML regeneration failed; importing existing file. ' . $th->getMessage());
            Log::channel('fetching_properties')->error('XML regeneration failed, importing existing file: ' . $th->getMessage());
        }

        // Step 2: import the XML into the database with a live progress bar.
        $this->newLine();
        $this->line('<fg=cyan>[2/3] Importing listings into the database...</>');
        $bar = null;
        $summary = app()->call('App\Http\Controllers\Api\BayutXmlIntegrationController@import', [
            'progress' => function (int $processed, int $total) use (&$bar) {
                if ($bar === null) {
                    $bar = $this->output->createProgressBar($total);
                    $bar->start();
                }
                $bar->setProgress($processed);
            },
        ]);
        if ($bar !== null) {
            $bar->finish();
            $this->newLine();
        }

        if (($summary['status'] ?? null) === 'error') {
            $this->error('      Import failed: ' . ($summary['message'] ?? 'unknown error'));
        } else {
            $this->info('      Import finished.');
            $this->table(
                ['Total', 'Imported', 'Failed', 'Deleted (stale)', 'Total images'],
                [[
                    $summary['total'] ?? 0,
                    $summary['imported'] ?? 0,
                    $summary['failed'] ?? 0,
                    $summary['deleted'] ?? 0,
                    $summary['images'] ?? 0,
                ]]
            );
        }

        // Step 3: rebuild the search index.
        $this->newLine();
        $this->line('<fg=cyan>[3/3] Rebuilding Meilisearch index...</>');
        $this->runMeilisearchIndex();

        $this->newLine();
        $this->info(sprintf('Done in %.1fs.', microtime(true) - $startedAt));

        return self::SUCCESS;
    }

    private function runMeilisearchIndex(): void
    {
        $phpFile = base_path('setup_meilisearch.php');

        if (! file_exists($phpFile)) {
            $this->warn('      Meilisearch script not found; skipping reindex.');
            Log::channel('fetching_properties')
                ->error("Meilisearch file not found: {$phpFile}");
            return;
        }

        Log::channel('fetching_properties')
            ->alert('Running Meilisearch indexing');

        exec(
            "php " . escapeshellarg($phpFile),
            $output,
            $resultCode
        );

        Log::channel('fetching_properties')
            ->alert("Meilisearch exit code: {$resultCode}");

        if ($resultCode === 0) {
            $this->info('      Search index rebuilt.');
        } else {
            $this->warn("      Meilisearch reindex exited with code {$resultCode} (is Meilisearch running?).");
        }

        if (! empty($output)) {
            Log::channel('fetching_properties')
                ->alert("Meilisearch output:\n" . implode("\n", $output));
        }
    }
}
