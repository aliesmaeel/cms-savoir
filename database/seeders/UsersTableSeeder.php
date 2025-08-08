<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // admin
        User::updateOrCreate(
            [
                'email' => "admin@savoirproperties.com"
            ],
            [
                'name' => 'Admin',
                'email' => "admin@savoirproperties.com",
                'email_verified_at' => now(),
                'password' => Hash::make('123456'), // password
                'role_id' => '1'
            ]
        );

        //superAdmin
        User::updateOrCreate(
            [
                'email' => "superAdmin@savoirproperties.com"
            ],
            [
                'name' => 'superAdmin',
                'email' => "superAdmin@savoirproperties.com",
                'email_verified_at' => now(),
                'password' => Hash::make('123456'), // password
                'role_id' => '5'
            ]
        );
        //photographer
        User::updateOrCreate(
            [
                'email' => "photographer@savoirproperties.com"
            ],
            [
                'name' => 'photographer',
                'email' => "photographer@savoirproperties.com",
                'email_verified_at' => now(),
                'password' => Hash::make('123456'), // password
                'role_id' => '6'
            ]
        );
        //agent
        User::updateOrCreate(
            [
                'email' => "agent@savoirproperties.com"
            ],
            [
                'name' => 'agent',
                'email' => "agent@savoirproperties.com",
                'email_verified_at' => now(),
                'password' => Hash::make('123456'), // password
                'role_id' => '3'
            ]
        );

    }
}
