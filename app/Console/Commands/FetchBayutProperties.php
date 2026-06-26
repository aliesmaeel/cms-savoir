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

        Log::channel('fetching_properties')->alert('Bayut pipeline start: regenerating XML from PropertyFinder');

        try {
            app()->call('App\Http\Controllers\PropertyXmlController@generateXml');
        } catch (\Throwable $th) {
            Log::channel('fetching_properties')->error('XML regeneration failed, importing existing file: ' . $th->getMessage());
        }

        app()->call('App\Http\Controllers\Api\BayutXmlIntegrationController@import');
        $this->runMeilisearchIndex();

        return self::SUCCESS;
    }

    private function runMeilisearchIndex(): void
    {
        $phpFile = base_path('setup_meilisearch.php');

        if (! file_exists($phpFile)) {
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

        if (! empty($output)) {
            Log::channel('fetching_properties')
                ->alert("Meilisearch output:\n" . implode("\n", $output));
        }
    }
}
