<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Donor extends Seeder
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
        $class = array("", "Regional Referral", "General");
        foreach (range(1,5) as $index){
            DB::table('donors')->insert([
                'donor_name' => $faker -> firstName,
                'administrator_ID' => $faker -> randomElement($admins),
            ]);
        }

    }
}
