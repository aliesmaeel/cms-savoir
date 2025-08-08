<?php

namespace Database\Seeders;

use App\Models\eventType;
use Illuminate\Database\Seeder;

class eventtypeseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        eventType::updateOrCreate([
            'name' => 'Open House',
        ]);
        eventType::updateOrCreate([
            'name' => 'New Launch',
        ]);
        eventType::updateOrCreate([
            'name' => 'Exhibition',
        ]);
    }
}
