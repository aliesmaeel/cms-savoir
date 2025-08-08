<?php

namespace App\Console\Commands;
ini_set('memory_limit', '-1');

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
        Log::channel('fetching_properties')->alert("Goyzer ferching start");
        app()->call('App\Http\Controllers\Api\GoyzerIntegrationConroller@get_goyzer_properties_for_sale');
        app()->call('App\Http\Controllers\Api\GoyzerIntegrationConroller@get_goyzer_properties_for_rent');
    }
}
