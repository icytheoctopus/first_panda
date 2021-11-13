<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $countriesData = [
            ['id' => 1, 'iso2' => 'AT', 'iso3' => 'AUT', 'name' => 'Austria'],
            ['id' => 2, 'iso2' => 'FR', 'iso3' => 'FRA', 'name' => 'France'],
            ['id' => 3, 'iso2' => 'DE', 'iso3' => 'DEU', 'name' => 'Germany'],
            ['id' => 4, 'iso2' => 'ES', 'iso3' => 'ESP', 'name' => 'Spain'],
            ['id' => 5, 'iso2' => 'RU', 'iso3' => 'RUS', 'name' => 'Russian Federation'],
            ['id' => 6, 'iso2' => 'CN', 'iso3' => 'CHN', 'name' => 'China'],
        ];

        foreach ($countriesData as $countryData){
            Country::factory()->create($countryData);
        }
    }
}
