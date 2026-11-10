<?php

namespace App\Console\Commands;

use App\Services\WebsiteFeedSyncService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Meilisearch\Client;
use Throwable;

class syncproperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:properties';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync website listings from the CRM feed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(WebsiteFeedSyncService $sync)
    {
        try {
            $summary = $sync->sync();
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());
            Log::error('Website feed sync failed: ' . $exception->getMessage());

            return 1;
        }

        if (!empty($summary['skipped'])) {
            $this->warn($summary['message']);

            return 0;
        }

        $this->info(sprintf(
            'Feed %d. Created %d, updated %d, unchanged %d, image galleries updated %d, sub-communities created %d, deleted %d, failed %d.',
            $summary['total'],
            $summary['created'],
            $summary['updated'],
            $summary['unchanged'],
            $summary['images_updated'],
            $summary['sub_communities_created'],
            $summary['deleted'],
            $summary['failed']
        ));

        $this->reindexSearch();

        return $summary['failed'] > 0 ? 1 : 0;
    }

    private function reindexSearch(): void
    {
        $host = (string) config('scout.meilisearch.host');
        $key = config('scout.meilisearch.key');

        try {
            $client = new Client($host, $key);
            $task = $client->index('new_properties')->deleteAllDocuments();
            $client->waitForTask($task['taskUid'], 120000);
        } catch (Throwable $exception) {
            $this->warn('Search index was not cleared: ' . $exception->getMessage());
            Log::warning('Website feed search clear failed: ' . $exception->getMessage());
        }

        $phpFile = base_path('setup_meilisearch.php');
        if (!is_file($phpFile)) {
            $this->warn('Meilisearch script not found; search index was not rebuilt.');

            return;
        }

        exec('php ' . escapeshellarg($phpFile), $output, $resultCode);

        if ($resultCode === 0) {
            $this->info('Search index rebuilt.');

            return;
        }

        $this->warn('Search reindex exited with code ' . $resultCode . '.');
        Log::warning('Website feed search reindex failed', ['output' => $output]);
    }
}
