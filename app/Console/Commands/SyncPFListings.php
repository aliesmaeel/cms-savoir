<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ListingSyncController;

class SyncPFListings extends Command
{
    // Yeh wahi signature hai jo aap terminal mein chalana chahte hain
    protected $signature = 'app:sync-listings';

    protected $description = 'Sync all listings from Property Finder to Pipedrive using Composite Logic';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Initializing Sync Process...');

        try {
            // Controller ka instance bana kar function call karna
            $controller = new ListingSyncController();
            $result = $controller->syncAllListings();

            $this->info($result);
            $this->info('Sync Finished Successfully!');
        } catch (\Exception $e) {
            $this->error('Error during sync: ' . $e->getMessage());
        }

        return 0;
    }
}