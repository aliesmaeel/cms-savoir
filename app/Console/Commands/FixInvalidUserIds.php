<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixInvalidUserIds extends Command
{
    protected $signature = 'fix:invalid-user-ids';

    /**
     * The console command description.
     */
    protected $description = 'Set user_id = 4 in new_properties if user does not exist in users table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch all user_ids from new_properties
        $invalidProperties = DB::table('new_properties')
            ->whereNotIn('user_id', function ($query) {
                $query->select('id')->from('users');
            })
            ->get(['id', 'user_id']);

        $count = $invalidProperties->count();

        if ($count === 0) {
            $this->info('✅ No invalid user_id found.');
            return 0;
        }

        // Update all invalid user_id entries to 4
        DB::table('new_properties')
            ->whereNotIn('user_id', function ($query) {
                $query->select('id')->from('users');
            })
            ->update(['user_id' => 4]);

        $this->info("✅ Updated {$count} records with invalid user_id to 4.");

        return 0;
    }
}
