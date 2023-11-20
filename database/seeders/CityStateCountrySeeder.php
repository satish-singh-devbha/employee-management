<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CityStateCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $this->insert_country();
        $this->insert_state();
        $this->insert_city();
    }

    public function insert_country() {

        $country_arrays = json_decode(file_get_contents(storage_path('app\country.json')), true);
        $country_lists = [];

        foreach ($country_arrays as $country_data) {

            $country_lists[] = [
                "name" => $country_data['name'],
                "country_code" => $country_data['country_code'],
                "created_at" => now(),
                "updated_at" => now(),
            ];
      
        }

        $country_count = Country::count();

        if ($country_count <= 0) {
            Country::insert($country_lists);
        }

    }

    public function insert_state() {

        $state_arrays = json_decode(file_get_contents(storage_path('app\state.json')), true);
        $state_lists = [];

        foreach ($state_arrays as $state_data) {

            $state_lists[] = [
                "name" => $state_data['name'],
                "country_id" => $state_data['country_id'],
                "created_at" => now(),
                "updated_at" => now(),
            ];
      
        }

        $state_count = State::count();

        if ($state_count <= 0) {
            State::insert($state_lists);
        }

    }

    public function insert_city() {

        $states_arrays = json_decode(file_get_contents(storage_path('app\city.json')), true);
        $city_lists = [];

        foreach($states_arrays as $city_arrays) {
      
            foreach ($city_arrays as $city_data) {

                $city_lists[] = [
                    "name" => $city_data['name'],
                    "state_id" => $city_data['state_id'],
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
          
            }
    
        }

        $city_count = City::count();

        if ($city_count <= 0) {
            City::insert($city_lists);
        }

    }
}
