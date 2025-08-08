<?php

namespace Database\Seeders;

use App\Models\PhotosheetType;
use Illuminate\Database\Seeder;

class photoshoottype extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PhotosheetType::updateOrCreate([
            'name' => 'Walkthrough',
        ]);
        PhotosheetType::updateOrCreate([
            'name' => 'Property Photo shoot',
        ]);
        PhotosheetType::updateOrCreate([
            'name' => 'Property Video Shoot ',
        ]);
        PhotosheetType::updateOrCreate([
            'name' => 'Event',
        ]);
        PhotosheetType::updateOrCreate([
            'name' => 'Show Room',
        ]);
    }
}
