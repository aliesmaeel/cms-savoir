<?php

namespace App\Console\Commands;

use App\Models\NewProperty;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurgeProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'properties:purge {--force : Skip the confirmation prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete ALL properties and their related images, videos and floor plans for a clean start';

    /**
     * Tables that hold property data or reference a property. Children are listed
     * first so deletion order is safe even when FK cascade is not enforced.
     *
     * @var string[]
     */
    private array $tables = [
        'property_images',
        'property_videos',
        'property_floor_plans',
        'finder_properties',
        'bayut_properties',
        'emirates_properties',
        'dubizzle_properties',
        'new_properties',
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $total = NewProperty::count();

        $this->warn("This will permanently delete ALL {$total} properties and their related images, videos and floor plans.");

        if (! $this->option('force') && ! $this->confirm('Are you sure you want to continue?')) {
            $this->info('Aborted. Nothing was deleted.');

            return self::SUCCESS;
        }

        $rows = [];

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        try {
            foreach ($this->tables as $table) {
                $deleted = DB::table($table)->delete();
                $rows[] = [$table, $deleted];
                $this->line("  cleared <fg=yellow>{$table}</> ({$deleted} rows)");
            }
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        // Remove the deleted listings from the search index too (best effort).
        try {
            NewProperty::removeAllFromSearch();
            $this->line('  cleared <fg=yellow>Meilisearch new_properties index</>');
        } catch (\Throwable $th) {
            $this->warn('  could not clear the search index (is Meilisearch running?): ' . $th->getMessage());
        }

        $this->newLine();
        $this->table(['Table', 'Deleted rows'], $rows);
        $this->info('Done. All properties and related media have been purged.');

        Log::channel('fetching_properties')->alert("properties:purge removed {$total} properties and related media");

        return self::SUCCESS;
    }
}
