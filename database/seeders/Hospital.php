<?php

namespace Database\Seeders;

use App\Models\Administrator;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Hospital extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $officers = \App\Models\Officer::all()->pluck('officer_Id')->toArray();
        $admin = \App\Models\User::all()->pluck('id')->toArray();
        $category = array("Private", "Public");
        $class = array("National Referral", "Regional Referral", "General");
        $postion = array("Director", "superintendent", "General head");

        foreach (range(1, 155) as $index) {
            DB::table('hospitals')->insert([
                'hospital_name' => $faker->name,
                'category' => $faker->randomElement($category),
                'class' => $faker->randomElement($class),
                'district' => $faker->state,

                'head_ID' => $faker->unique()->numberBetween(1,155),
                'head_name' => $faker->firstName,
                'waiting' => $faker->boolean,
                'monthly_payment' => $faker->numberBetween(50,100),
                'award_payment' => $faker->numberBetween(50,100),
                'password' => $faker->password,
                'officer_position' => $faker->randomElement($postion),
                'administrator_ID' => $faker->randomElement($admin),
            ]);

        }
    }
}
