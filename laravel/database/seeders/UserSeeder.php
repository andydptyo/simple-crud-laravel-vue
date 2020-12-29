<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\City;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereHas('roles', function ($role) {
            $role->where('name', 'admin');
        })->first();

        $city = City::where('name', 'Sidoarjo')->first();

        if (!$user) {
            $user = User::create([
                'first_name' => 'Admin',
                'last_name' => 'Superhelper',
                'email' => 'admin@superhelper.id',
                'password' => bcrypt('123456789'),
                'phone' => '81232252562',
                'birthday' => '1989-05-12',
                'city_id' => $city->id,
                'remember_token' => Str::random(10),
            ]);

            $user->assignRole('admin');
            $user->createToken('admin', ['user:delete'])->plainTextToken;
        }
    }
}
