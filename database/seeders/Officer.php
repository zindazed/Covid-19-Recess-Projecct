<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Carbon\Carbon;
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
        $heads = Hospital::all()->pluck('head_ID')->toArray();
        $postion = array("Health Officer", "Senior health Officer", "Consultant");

        foreach (range(1,300) as $index){
            DB::table('officers')->insert([
                'officer_name' => $faker -> firstName,
                'password' => $faker -> password,
                'officer_position' => "Health Officer",//$faker -> randomElement($postion),
                'Retired' => 0,
                'head_ID' => $faker -> randomElement($heads),
                'administrator_ID' => $faker -> randomElement($admins),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
