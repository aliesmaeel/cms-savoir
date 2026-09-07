<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class Repair33Deals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:repair-33-deals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repairs the owner of exactly 16 specific deals in Pipedrive, assigning them to Edward Paul.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting 16 Deals Owner Repair Process (Target: Edward Paul)...');

        $pipedriveToken = env('PIPEDRIVE_TOKEN');
        if (empty($pipedriveToken)) {
            $this->error('PIPEDRIVE_TOKEN is missing from .env');
            return 1;
        }

        // Updated Target Data (16 remaining properties, mapped to Edward Paul)
        $targetData = [
            '7850-25422816' => 'Edward Paul',
            '8791-25422816' => 'Edward Paul',
            '10531-25422816-1' => 'Edward Paul',
            '10531-25699356' => 'Edward Paul',
            '10525-25552946-1' => 'Edward Paul',
            '10422-25699356' => 'Edward Paul',
            '10382-25699356' => 'Edward Paul',
            '10276-25383095' => 'Edward Paul',
            '10212-25771934' => 'Edward Paul',
            '10154-25699356' => 'Edward Paul',
            '10037-25771934' => 'Edward Paul',
            '10017-25552946-1' => 'Edward Paul',
            '7850-25699356' => 'Edward Paul',
            '3178-25771934' => 'Edward Paul',
            '3057-25422816' => 'Edward Paul',
            '2902-25473361' => 'Edward Paul',
        ];

        $userMapping = [
            'Edward Paul' => 25366837,
            'Elias' => 21096602,
            'Armaan' => 26501234,
            'Chris Missi' => 25552946,
            'Nicole Ras' => 25422816,
            'Sara' => 26232966,
            'Rami Ben Ali' => 25553430,
            'Rohan Manoj' => 25998061,
            'Maria Millan' => 25473361,
            'Fadi' => 25671339,
            'Wahaj Ali' => 25683241,
            'Annie' => 25654927,
            'Hammad' => 25503666,
            'Dekara' => 25442429,
            'Joey' => 25683219,
            'Sabeehah' => 26501245,
            'Nain' => 25427524,
        ];

        $successCount = 0;
        $failedCount = 0;

        foreach ($targetData as $ref => $ownerName) {
            $this->line("Processing Reference: {$ref} -> Target Owner: {$ownerName}");

            // 1. Search Pipedrive for the Deal ID using the reference
            $searchResponse = Http::get("https://api.pipedrive.com/v1/deals/search", [
                'api_token' => $pipedriveToken,
                'term' => (string) $ref,
                'fields' => 'custom_fields',
                'exact_match' => true
            ]);

            $dealId = null;
            if ($searchResponse->successful()) {
                $searchResults = $searchResponse->json('data.items');
                if (!empty($searchResults)) {
                    // Loop through search results to verify the specific custom field matches exactly
                    foreach ($searchResults as $result) {
                        $possibleDealId = $result['item']['id'] ?? null;
                        if ($possibleDealId) {
                            // Fetch full deal to verify the exact custom field since search API doesn't return full mapped fields
                            $dealResponse = Http::get("https://api.pipedrive.com/v1/deals/{$possibleDealId}", [
                                'api_token' => $pipedriveToken
                            ]);
                            if ($dealResponse->successful()) {
                                $dealData = $dealResponse->json('data');
                                $dealRef = $dealData['c7d4db817f241ce7c70ee06bf930314ef6e20e95'] ?? null;
                                
                                if ($dealRef === (string) $ref) {
                                    $dealId = $possibleDealId;
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            if (!$dealId) {
                $this->error("Failed to find exact matching Deal ID for Reference: {$ref}");
                $failedCount++;
                sleep(1);
                continue;
            }

            // 2. Validate mapping ID
            if (!isset($userMapping[$ownerName])) {
                $this->error("Target Owner '{$ownerName}' not found in user ID mapping table.");
                $failedCount++;
                sleep(1);
                continue;
            }

            $targetUserId = $userMapping[$ownerName];

            // 3. Update Deal
            $updateResponse = Http::put("https://api.pipedrive.com/v1/deals/{$dealId}?api_token={$pipedriveToken}", [
                'user_id' => $targetUserId
            ]);

            if ($updateResponse->successful()) {
                $this->info("SUCCESS: Updated Deal ID {$dealId} (Ref: {$ref}) to Owner: {$ownerName} ({$targetUserId})");
                $successCount++;
            } else {
                $this->error("FAILED to update Deal ID {$dealId}: " . $updateResponse->body());
                $failedCount++;
            }

            // Sleep to avoid Pipedrive rate limits
            sleep(1);
        }

        $this->info("Repair complete! Successfully updated: {$successCount} | Failed: {$failedCount}");
        return 0;
    }
}
