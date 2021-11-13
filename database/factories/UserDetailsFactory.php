<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDetailsFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'citizenship_country_id' => Country::factory()->create()->id,

            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
        ];
    }
}
