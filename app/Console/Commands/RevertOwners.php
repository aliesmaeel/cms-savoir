<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class RevertOwners extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:revert-owners';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revert deal owners based on the Previous Owner custom field.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Owner Reversion Process...');

        $pipedriveToken = env('PIPEDRIVE_TOKEN');
        if (empty($pipedriveToken)) {
            $this->error('PIPEDRIVE_TOKEN is missing from .env');
            return 1;
        }

        $ownerMapping = [
            'Adriana'          => 25427502,
            'Anna'             => 25427480,
            'Annet Nassuuna'   => 25383128,
            'Annie'            => 25654927,
            'Armaan'           => 26501234,
            'Asha Makwana'     => 25488035,
            'Axsh Shreshtha'   => 25692965,
            'Aya Elhadad'      => 26610684,
            'Bismah Bhatti'    => 26369366,
            'Chakib Nouri'     => 25654938,
            'Charles Martin'   => 25699356,
            'Chris Missi'      => 25552946,
            'Dekara'           => 25442429,
            'Diana'            => 25427491,
            'Edward Paul'      => 25366837,
            'Elias'            => 21096602,
            'Eva Bogotlieva'   => 25383106,
            'Fadi'             => 25671339,
            'Georgina'         => 25762529,
            'Hammad'           => 25503666,
            'Hanli'            => 26009820,
            'James Davies'     => 26393962,
            'Joey'             => 25683219,
            'Lina Krasimirova' => 25427513,
            'Luiza Dragan'     => 25427458,
            'Mahmoud Elassi'   => 25462405,
            'Maria Millan'     => 25473361,
            'Milena'           => 25427447,
            'Mohammad Farhat'  => 25664299,
            'Mouad Anis'       => 25998050,
            'Muhammad Uzair'   => 25512928,
            'Nain'             => 25427524,
            'Nicola Daley'     => 25383095,
            'Nicole Ras'       => 25422816,
            'Rahil Ibrahim'    => 25580798,
            'Rami Ben Ali'     => 25553430,
            'riad'             => 25592689,
            'Riz'              => 25497550,
            'Rohan Manoj'      => 25998061,
            'Sabeehah'         => 26501245,
            'Sara'             => 26232966,
            'Simon'            => 25683230,
            'Suraj'            => 25771934,
            'Svetla Durrani'   => 25427436,
            'Umar'             => 25547600,
            'Vessela'          => 25383117,
            'Wahaj Ali'        => 25683241,
            'Zoza'             => 25427469,
        ];

        // Lowercase the keys for case-insensitive matching
        $normalizedMapping = [];
        foreach ($ownerMapping as $name => $id) {
            $normalizedMapping[strtolower(trim($name))] = $id;
        }

        $start = 0;
        $limit = 100; // Pipedrive maximum
        $processed = 0;
        $updated = 0;

        do {
            $response = Http::get("https://api.pipedrive.com/v1/deals", [
                'api_token' => $pipedriveToken,
                'start' => $start,
                'limit' => $limit
            ]);

            if (!$response->successful()) {
                $this->error('Failed to fetch deals from Pipedrive: ' . $response->body());
                break;
            }

            $data = $response->json();
            $deals = $data['data'] ?? [];

            if (empty($deals)) {
                break;
            }

            foreach ($deals as $deal) {
                // Only process Pipeline ID 3
                if (isset($deal['pipeline_id']) && $deal['pipeline_id'] == 3) {
                    $dealId = $deal['id'];
                    $dealTitle = $deal['title'] ?? "Deal #{$dealId}";
                    
                    // Field ID for 'Previous Owner'
                    $previousOwnerName = $deal['3d627ee1a8e8e3e01eaac0e2daedd41c7e77ae7d'] ?? null;

                    if ($previousOwnerName) {
                        $normalizedName = strtolower(trim($previousOwnerName));
                        
                        if (array_key_exists($normalizedName, $normalizedMapping)) {
                            $correctUserId = $normalizedMapping[$normalizedName];
                            
                            // Check if it's already assigned to the correct user to save API calls
                            $currentUserId = data_get($deal, 'user_id.id') ?? data_get($deal, 'user_id');
                            
                            if ($currentUserId != $correctUserId) {
                                $this->info("Updating Deal: {$dealTitle} (ID: {$dealId}) -> Reverting Owner to {$previousOwnerName}");
                                
                                $updateResponse = Http::put("https://api.pipedrive.com/v1/deals/{$dealId}?api_token={$pipedriveToken}", [
                                    'user_id' => $correctUserId
                                ]);
                                
                                if ($updateResponse->successful()) {
                                    $updated++;
                                } else {
                                    $this->error("Failed to update Deal ID {$dealId}: " . $updateResponse->body());
                                }
                                
                                // Pipedrive Rate Limit Protection
                                sleep(1);
                            }
                        }
                    }
                }
                $processed++;
            }

            $pagination = $data['additional_data']['pagination'] ?? [];
            $moreItems = $pagination['more_items_in_collection'] ?? false;
            $start = $pagination['next_start'] ?? ($start + $limit);

        } while ($moreItems);

        $this->info("Process Complete! Scanned {$processed} deals and successfully reverted {$updated} owners.");
        return 0;
    }
}
