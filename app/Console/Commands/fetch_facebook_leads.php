<?php

namespace App\Console\Commands;

use App\Http\Controllers\leadsregisteController;
use Illuminate\Console\Command;

class fetch_facebook_leads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facebook:fetchleads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        app()->call('App\Http\Controllers\leadsregisteController@facebook_jvc_lead_store');
        app()->call('App\Http\Controllers\leadsregisteController@facebook_westwood_lead_store');
        app()->call('App\Http\Controllers\leadsregisteController@facebook_miami_lead_store');
        exit();
    }
}
