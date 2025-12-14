<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchGoyzerProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:goyzerproperties';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch properties from goyzer portal';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');

        Log::channel('fetching_properties')->alert("Goyzer ferching start");
       app()->call('App\Http\Controllers\Api\GoyzerIntegrationConroller@get_goyzer_properties_for_sale');
       app()->call('App\Http\Controllers\Api\GoyzerIntegrationConroller@get_goyzer_properties_for_rent');
        $this->runMeilisearchIndex();
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
