<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \App\Models\Administrator;

class Officer extends Seeder
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
        $hospitals = Hospital::all()->pluck('head_ID')->toArray();
        $category = array("Private", "Public");
        $class = array("National Referral", "Regional Referral", "General");
        $postion = array("Health Officer", "Senior health Officer", "Consultant");

        foreach (range(1,100) as $index){
            DB::table('officers')->insert([
                'officer_name' => $faker -> firstName,
                'waiting' => $faker ->boolean,
                'password' => $faker -> password,
                'officer_position' => $faker -> randomElement($postion),
                'head_ID' => $faker -> randomElement($hospitals),
                'administrator_ID' => $faker -> randomElement($admins),
            ]);
        }
    }
}
