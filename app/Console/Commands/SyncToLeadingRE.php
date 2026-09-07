<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LeadingREXmlService;
use Illuminate\Support\Facades\Log;

class SyncToLeadingRE extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:leadingre';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate LeadingRE XML Feed from Pipedrive Deals';

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
    public function handle(LeadingREXmlService $xmlService)
    {
        $this->info('Starting LeadingRE XML generation...');

        try {
            $filePath = $xmlService->generateFeed();

            if ($filePath) {
                $this->info('XML feed successfully generated at: ' . $filePath);
            } else {
                $this->warn('No eligible deals found to sync or feed generation failed.');
            }

            return 0;
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
            Log::error('LeadingRE Command Error: ' . $e->getMessage());
            return 1;
        }
    }
}
