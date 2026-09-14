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
            $result = $xmlService->generateFeed();

            if ($result && isset($result['file_path'])) {
                $filePath = $result['file_path'];
                $totalDeals = $result['total_deals'] ?? 0;
                
                $this->info('Total eligible deals fetched: ' . $totalDeals);
                $this->info('Local XML file path generated: ' . $filePath);
                
                $this->info('Uploading to LeadingRE SFTP server...');
                $fileName = basename($filePath);
                
                $uploaded = \Illuminate\Support\Facades\Storage::disk('leadingre_sftp')->put(
                    $fileName,
                    file_get_contents($filePath)
                );
                
                if ($uploaded) {
                    $this->info('SFTP upload status: Success. File ' . $fileName . ' has been uploaded.');
                } else {
                    $this->error('SFTP upload status: Failed to upload the file to the SFTP server.');
                    return 1;
                }
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
