<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country1 = Country::firstOrCreate(
            ['code'=>'','name' => 'United Arab Emirates'],
            ['name' => 'United Arab Emirates','code'=>'']
        );
        City::firstOrCreate(
            ['name' => 'Dubai', 'country_id' => $country1->id],
            [
                'name' => 'Dubai',
                'country_id' => $country1->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Abu Dhabi', 'country_id' => $country1->id],
            [
                'name' => 'Abu Dhabi',
                'country_id' => $country1->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Umm Al Quwai', 'country_id' => $country1->id],
            [
                'name' => 'Umm Al Quwai',
                'country_id' => $country1->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Ajman', 'country_id' => $country1->id],
            [
                'name' => 'Ajman',
                'country_id' => $country1->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Ras Al-Khaimah', 'country_id' => $country1->id],
            [
                'name' => 'Ras Al-Khaimah',
                'country_id' => $country1->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Sharjah', 'country_id' => $country1->id],
            [
                'name' => 'Sharjah',
                'country_id' => $country1->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Fujairah', 'country_id' => $country1->id],
            [
                'name' => 'Fujairah',
                'country_id' => $country1->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Al Ain', 'country_id' => $country1->id],
            [
                'name' => 'Al Ain',
                'country_id' => $country1->id
            ]
        );
        $country2 = Country::firstOrCreate(
            ['code'=>'','name' => 'Bulgaria'],
            ['name' => 'Bulgaria','code'=>'']
        );
        City::firstOrCreate(
            ['name' => 'Sofia', 'country_id' => $country2->id],
            [
                'name' => 'Sofia',
                'country_id' => $country2->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Plovdiv','country_id' => $country2->id],
            [
                'name' => 'Plovdiv',
                'country_id' => $country2->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Varna','country_id' => $country2->id],
            [
                'name' => 'Varna',
                'country_id' => $country2->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Burgas','country_id' => $country2->id],
            [
                'name' => 'Burgas',
                'country_id' => $country2->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Stara Zagora','country_id' => $country2->id],
            [
                'name' => 'Stara Zagora',
                'country_id' => $country2->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Rousse','country_id' => $country2->id],
            [
                'name' => 'Rousse',
                'country_id' => $country2->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Pleven','country_id' => $country2->id],
            [
                'name' => 'Pleven',
                'country_id' => $country2->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Sliven','country_id' => $country2->id],
            [
                'name' => 'Sliven',
                'country_id' => $country2->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Pernik','country_id' => $country2->id],
            [
                'name' => 'Pernik',
                'country_id' => $country2->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Dobrich','country_id' => $country2->id],
            [
                'name' => 'Dobrich',
                'country_id' => $country2->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Shumen','country_id' => $country2->id],
            [
                'name' => 'Shumen',
                'country_id' => $country2->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Blagoevgrad','country_id' => $country2->id],
            [
                'name' => 'Blagoevgrad',
                'country_id' => $country2->id
            ]
        );
        $country3 = Country::firstOrCreate(
            ['code'=>'','name' => 'Greek'],
            ['name' => 'Greek','code'=>'']
        );
        City::firstOrCreate(
            ['name' => 'Attica','country_id' => $country3->id],
            [
                'name' => 'Attica',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Thessaloniki','country_id' => $country3->id],
            [
                'name' => 'Thessaloniki',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Patras','country_id' => $country3->id],
            [
                'name' => 'Patras',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Heraklion','country_id' => $country3->id],
            [
                'name' => 'Heraklion',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Larissa','country_id' => $country3->id],
            [
                'name' => 'Larissa',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Volos','country_id' => $country3->id],
            [
                'name' => 'Volos',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Ioannina','country_id' => $country3->id],
            [
                'name' => 'Ioannina',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Kalamata','country_id' => $country3->id],
            [
                'name' => 'Kalamata',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Chania','country_id' => $country3->id],
            [
                'name' => 'Chania',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Rhodes','country_id' => $country3->id],
            [
                'name' => 'Rhodes',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Corfu','country_id' => $country3->id],
            [
                'name' => 'Corfu',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Chalkida','country_id' => $country3->id],
            [
                'name' => 'Chalkida',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Agrinio','country_id' => $country3->id],
            [
                'name' => 'Agrinio',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Tripoli','country_id' => $country3->id],
            [
                'name' => 'Tripoli',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Serres','country_id' => $country3->id],
            [
                'name' => 'Serres',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Zakynthos','country_id' => $country3->id],
            [
                'name' => 'Zakynthos',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Crete','country_id' => $country3->id],
            [
                'name' => 'Crete',
                'country_id' => $country3->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Agios Nikolaos','country_id' => $country3->id],
            [
                'name' => 'Agios Nikolaos',
                'country_id' => $country3->id
            ]
        );
        $country4 = Country::firstOrCreate(
            ['code'=>'','name' => 'Cyprus'],
            ['name' => 'Cyprus','code'=>'']
        );
        City::firstOrCreate(
            ['name' => 'Nicosia (Lefkosia)','country_id' => $country4->id],
            [
                'name' => 'Nicosia (Lefkosia)',
                'country_id' => $country4->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Limassol','country_id' => $country4->id],
            [
                'name' => 'Limassol',
                'country_id' => $country4->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Larnaca','country_id' => $country4->id],
            [
                'name' => 'Larnaca',
                'country_id' => $country4->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Paphos','country_id' => $country4->id],
            [
                'name' => 'Paphos',
                'country_id' => $country4->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Famagusta','country_id' => $country4->id],
            [
                'name' => 'Famagusta',
                'country_id' => $country4->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Kyrenia','country_id' => $country4->id],
            [
                'name' => 'Kyrenia',
                'country_id' => $country4->id
            ]
        );
        $country5 = Country::firstOrCreate(
            ['code'=>'','name' => 'Malta'],
            ['name' => 'Malta','code'=>'']
        );
        City::firstOrCreate(
            ['name' => 'Valletta','country_id' => $country5->id],
            [
                'name' => 'Valletta',
                'country_id' => $country5->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Mosta','country_id' => $country5->id],
            [
                'name' => 'Mosta',
                'country_id' => $country5->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Sliema','country_id' => $country5->id],
            [
                'name' => 'Sliema',
                'country_id' => $country5->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Zabbar','country_id' => $country5->id],
            [
                'name' => 'Zabbar',
                'country_id' => $country5->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Rabat (Victoria)','country_id' => $country5->id],
            [
                'name' => 'Rabat (Victoria)',
                'country_id' => $country5->id
            ]
        );
        City::firstOrCreate(
            ['name' => 'Zebbug','country_id' => $country5->id],
            [
                'name' => 'Zebbug',
                'country_id' => $country5->id
            ]
        );
         Country::firstOrCreate(
            ['code'=>'','name' => 'Saudi Arabia'],
            ['name' => 'Saudi Arabia','code'=>'']
        );
        Country::firstOrCreate(
            ['code'=>'','name' => 'Kuwait'],
            ['name' => 'Kuwait','code'=>'']
        );
        Country::firstOrCreate(
            ['code'=>'','name' => 'Oman'],
            ['name' => 'Oman','code'=>'']
        );
        Country::firstOrCreate(
            ['code'=>'','name' => 'Qatar'],
            ['name' => 'Qatar','code'=>'']
        );
        Country::firstOrCreate(
            ['code'=>'','name' => 'Portugal'],
            ['name' => 'Portugal','code'=>'']
        );
        Country::firstOrCreate(
            ['code'=>'','name' => 'Portugal'],
            ['name' => 'Portugal','code'=>'']
        );
        Country::firstOrCreate(
            ['code'=>'','name' => 'Greece'],
            ['name' => 'Greece','code'=>'']
        );
        Country::firstOrCreate(
            ['code'=>'','name' => 'Spain'],
            ['name' => 'Spain','code'=>'']
        );


    }
}
