<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Database\Seeders\CountriesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CamoaignSeeder::class);
        $this->call(eventtypeseeder::class);
        $this->call(photoshoottype::class);
        $this->call(CountriesSeeder::class);
    }
}
