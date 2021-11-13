<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDetailsFactory extends Factory
{
    public function definition()
    {
        $user = User::all()->random() ?? User::factory()->create();
        $country = Country::all()->random() ?? Country::factory()->create();

        return [
            'user_id' => $user->id,
            'citizenship_country_id' => $country->id,

            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
        ];
    }
}
