<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function get_only_active_users_by_country_code()
    {
        $country = Country::factory()->create([
            'iso2' => 'TS',
            'iso3' => 'TST',
        ]);
        $user = User::factory()->inactive()->create();
        $userDetails = UserDetails::factory()->create([
            'user_id' => $user->id,
            'citizenship_country_id' => $country->id,
        ]);

        $response = $this->get("/api/users/country/$country->iso2");

        $response->assertStatus(200);
        $response->assertJsonMissing([
                'id' => $user->id,
                'email' => $user->email
            ]
        );

        $user->active = 1;
        $user->save();

        $response = $this->get("/api/users/country/$country->iso2");

        $response->assertStatus(200);
        $response->assertJsonFragment([
                'id' => $user->id,
                'email' => $user->email
            ]
        );
    }

    /** @test */
    public function get_active_users_by_country_code_iso2()
    {
        $country = Country::factory()->create([
            'iso2' => 'TS',
            'iso3' => 'TST',
        ]);
        $user = User::factory()->active()->create();

        $response = $this->get("/api/users/country/$country->iso2");

        $response->assertStatus(200);
        $response->assertJsonMissing([
                'id' => $user->id,
                'email' => $user->email
            ]
        );

        $userDetails = UserDetails::factory()->create([
            'user_id' => $user->id,
            'citizenship_country_id' => $country->id,
        ]);

        $response = $this->get("/api/users/country/$country->iso2");

        $response->assertStatus(200);
        $response->assertJsonFragment([
                'id' => $user->id,
                'email' => $user->email
            ]
        );
    }

    /** @test */
    public function get_active_users_by_country_code_iso3()
    {
        $country = Country::factory()->create([
            'iso2' => 'TS',
            'iso3' => 'TST',
        ]);
        $user = User::factory()->active()->create();

        $response = $this->get("/api/users/country/$country->iso2");

        $response->assertStatus(200);
        $response->assertJsonMissing([
                'id' => $user->id,
                'email' => $user->email
            ]
        );

        $userDetails = UserDetails::factory()->create([
            'user_id' => $user->id,
            'citizenship_country_id' => $country->id,
        ]);

        $response = $this->get("/api/users/country/$country->iso2");

        $response->assertStatus(200);
        $response->assertJsonFragment([
                'id' => $user->id,
                'email' => $user->email
            ]
        );
    }

    /** @test */
    public function edit_user_details(){
        $user = User::factory()->active()->create();
        $userDetails = UserDetails::factory()->create([
            'user_id' => $user->id,
        ]);

        $newCountry = Country::factory()->create();
        $userDetailsUpdateAttributes = [
            'first_name' => 'First Name UPDATED',
            'last_name' => 'Last Name UPDATED',
            'phone_number' => 'Phone UPDATED',
            'citizenship_country_id' => $newCountry->id,
        ];

        $this->assertDatabaseHas('user_details', $userDetails->toArray());
        $response = $this->patch("/api/users/$user->id/details/", $userDetailsUpdateAttributes);

        $response->assertStatus(200);
        $this->assertDatabaseHas('user_details', $userDetailsUpdateAttributes);
        $this->assertDatabaseMissing('user_details', $userDetails->toArray());
    }

    /** @test */
    public function edit_user_details_only_if_they_exist(){
        $user = User::factory()->active()->create();
        $country = Country::factory()->create();
        $userDetailsUpdateAttributes = [
            'user_id' => $user->id,
            'first_name' => 'First Name UPDATED',
            'last_name' => 'Last Name UPDATED',
            'phone_number' => 'Phone UPDATED',
            'citizenship_country_id' => $country->id,
        ];

        $this->assertDatabaseMissing('user_details', $userDetailsUpdateAttributes);
        $response = $this->patch("/api/users/$user->id/details/", $userDetailsUpdateAttributes);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('user_details', $userDetailsUpdateAttributes);
    }

    /** @test */
    public function delete_user_without_user_details(){
        $user = User::factory()->active()->create();

        $response = $this->delete('/api/users/'.$user->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function unable_to_delete_user_with_user_details(){
        $user = User::factory()
            ->active()
            ->has(UserDetails::factory()->count(1), 'details')
            ->create();

        $response = $this->delete('/api/users/'.$user->id);

        $response->assertStatus(403);
    }
}
