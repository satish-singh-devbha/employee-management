<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAddress>
 */
class UserAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $state_id = State::first()->id;
        
        return [
            'user_id' => User::factory(),
            'street_name' => fake()->streetName(),
            'building_no' => fake()->buildingNumber(),
            'city' => City::where("state_id", $state_id)->first()->id,
            'state' => State::first()->id,
            'country' => Country::first()->id,
            'pincode' => fake()->postcode()
        ];
    }
}
