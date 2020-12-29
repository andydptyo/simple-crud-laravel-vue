<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::updateOrCreate([
            'name' => 'Jakarta',
        ],
        [
            'name' => 'Jakarta',
        ]);

        City::updateOrCreate([
            'name' => 'Surabaya',
        ],
        [
            'name' => 'Surabaya',
        ]);

        City::updateOrCreate([
            'name' => 'Sidoarjo',
        ],
        [
            'name' => 'Sidoarjo',
        ]);

    }
}
