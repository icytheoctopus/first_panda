<?php

namespace Database\Seeders;

use App\Models\UserDetails;
use Illuminate\Database\Seeder;

class UserDetailsSeeder extends Seeder
{
    public function run()
    {
        $userDetailsRows = [
            [
                'id' => 1,
                'user_id' => 1,
                'citizenship_country_id' => 1,
                'first_name' => 'Alex',
                'last_name' => 'Petro',
                'phone_number' => '0043664111111'
            ],
            [
                'id' => 2,
                'user_id' => 4,
                'citizenship_country_id' => 1,
                'first_name' => 'Dominik',
                'last_name' => 'Allan',
                'phone_number' => '00436644444444'
            ],
            [
                'id' => 3,
                'user_id' => 5,
                'citizenship_country_id' => 3,
                'first_name' => 'Andreas',
                'last_name' => 'Snow',
                'phone_number' => '004366455555555'
            ],
            [
                'id' => 4,
                'user_id' => 7,
                'citizenship_country_id' => 5,
                'first_name' => 'Igor',
                'last_name' => 'Snow',
                'phone_number' => '0043664777777'
            ],
            [
                'id' => 5,
                'user_id' => 6,
                'citizenship_country_id' => 1,
                'first_name' => 'Max',
                'last_name' => 'Mustermann',
                'phone_number' => '00436646666666'
            ],
        ];

        foreach ($userDetailsRows as $userDetailsRow){
            UserDetails::factory()->create($userDetailsRow);
        }
    }
}
