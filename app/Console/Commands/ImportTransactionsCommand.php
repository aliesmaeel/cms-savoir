<?php

namespace App\Console\Commands;

use App\Models\HistoryTransactionsArea;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportTransactionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:import {--force : Force import even if table exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import transactions from Transactions_2025.csv file. Truncates table if it already exists.';

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

        $filePath = public_path('Transactions_2025.csv');

        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            $this->info("Please make sure Transactions_2025.csv exists in the public folder.");
            return 1;
        }

        $this->info("Found file: {$filePath}");

        // Check if table exists
        $tableExists = Schema::hasTable('history_transactions_area');

        if (!$tableExists) {
            $this->warn("Table 'history_transactions_area' does not exist.");
            $this->info("Running migration...");
            
            try {
                \Artisan::call('migrate', ['--path' => 'database/migrations/2026_01_05_023004_create_history_transactions_area_table.php', '--force' => true]);
                $this->info("Migration completed successfully.");
            } catch (\Exception $e) {
                $this->error("Migration failed: " . $e->getMessage());
                $this->info("Please run: php artisan migrate");
                return 1;
            }
        } else {
            $this->info("Table 'history_transactions_area' exists.");
            
            // Check if table has data
            $recordCount = HistoryTransactionsArea::count();
            if ($recordCount > 0) {
                $this->warn("Table contains {$recordCount} records. Truncating...");
                DB::table('history_transactions_area')->truncate();
                $this->info("Table truncated successfully.");
            } else {
                $this->info("Table is empty. Proceeding with import...");
            }
        }

        $this->info("Starting import from: {$filePath}");

        $file = fopen($filePath, 'r');

        if ($file === false) {
            $this->error("Could not open file: {$filePath}");
            return 1;
        }

        // Read header row
        $headers = fgetcsv($file);
        if ($headers === false) {
            $this->error("Could not read header row");
            fclose($file);
            return 1;
        }

        $this->info("Found columns: " . count($headers));
        $this->info("Importing data...");

        $batchSize = 500;
        $batch = [];
        $rowCount = 0;
        $importedCount = 0;

        try {
            while (($row = fgetcsv($file)) !== false) {
                if (count($row) !== count($headers)) {
                    continue; // Skip malformed rows
                }

                $data = array_combine($headers, $row);
                
                // Convert empty strings to null for nullable fields
                foreach ($data as $key => $value) {
                    if ($value === '' || strtolower($value) === 'null') {
                        $data[$key] = null;
                    }
                }

                // Format date
                if (!empty($data['instance_date'])) {
                    try {
                        $date = \Carbon\Carbon::createFromFormat('d-m-Y', $data['instance_date']);
                        $data['instance_date'] = $date->format('Y-m-d');
                    } catch (\Exception $e) {
                        $data['instance_date'] = null;
                    }
                }

                // Convert numeric fields
                $numericFields = [
                    'procedure_id', 'trans_group_id', 'property_type_id', 'reg_type_id',
                    'area_id', 'has_parking', 'no_of_parties_role_1', 'no_of_parties_role_2',
                    'no_of_parties_role_3'
                ];
                foreach ($numericFields as $field) {
                    if (isset($data[$field]) && $data[$field] !== null) {
                        $data[$field] = is_numeric($data[$field]) ? (int)$data[$field] : null;
                    }
                }

                $decimalFields = [
                    'procedure_area', 'actual_worth', 'meter_sale_price',
                    'rent_value', 'meter_rent_price'
                ];
                foreach ($decimalFields as $field) {
                    if (isset($data[$field]) && $data[$field] !== null) {
                        $data[$field] = is_numeric($data[$field]) ? (float)$data[$field] : null;
                    }
                }

                $batch[] = $data;
                $rowCount++;

                if (count($batch) >= $batchSize) {
                    DB::beginTransaction();
                    try {
                        HistoryTransactionsArea::insert($batch);
                        DB::commit();
                        $importedCount += count($batch);
                        $this->info("Imported {$importedCount} records...");
                    } catch (\Exception $e) {
                        DB::rollBack();
                        $this->error("Error inserting batch: " . $e->getMessage());
                        throw $e;
                    }
                    $batch = [];
                    gc_collect_cycles(); // Force garbage collection
                }
            }

            // Insert remaining records
            if (!empty($batch)) {
                DB::beginTransaction();
                try {
                    HistoryTransactionsArea::insert($batch);
                    DB::commit();
                    $importedCount += count($batch);
                } catch (\Exception $e) {
                    DB::rollBack();
                    $this->error("Error inserting final batch: " . $e->getMessage());
                    throw $e;
                }
            }

            fclose($file);

            $this->info("Import completed successfully!");
            $this->info("Total records imported: {$importedCount}");
            
            return 0;
        } catch (\Exception $e) {
            fclose($file);
            $this->error("Error during import: " . $e->getMessage());
            return 1;
        }
    }
}
