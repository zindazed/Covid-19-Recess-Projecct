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

        $admins = \App\Models\User::all()->pluck('id')->toArray();
        $category = array("Private", "Public");
        $class = array("National Referral", "Regional Referral", "General");
        $postion = array("Head", "Superintendent", "Director");
        foreach (range(1, 5) as $index) {
            DB::table('hospitals')->insert([
                'hospital_name' => $faker->name,
                'category' => $faker->randomElement($category),
                'class' => $faker->randomElement($class),
                'district' => $faker->state,

                'head_name' => $faker->firstName,
                'Email' => $faker->email,
                'password' => $faker->password,
                'officer_position' => $faker->randomElement($postion),
                'administrator_ID' => $faker->randomElement($admins),
                'created_at' => $faker -> date('Y-m-d H:i:s'),
                'updated_at' => $faker -> date('Y-m-d H:i:s'),
            ]);

        }
    }
}
