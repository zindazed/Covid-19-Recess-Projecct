<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $admins = \App\Models\User::all()->pluck('id')->toArray();

        foreach (range(1,3) as $index){
            DB::table('users')->insert([
                'name' => $faker -> name,
                'email' => $faker ->email,
                'email_verified_at' => $faker -> date(),
                'password' => $faker -> password,
                'is_admin' => $faker -> boolean,
            ]);
        }

        foreach (range(1,5) as $index){
            DB::table('donors')->insert([
                'donor_name' => $faker -> name,
                'administrator_ID' => $faker -> randomElement($admins),
            ]);
        }

        $admins = \App\Models\User::all()->pluck('id')->toArray();
        $donors = \App\Models\Donor::all()->pluck('donor_ID')->toArray();
        foreach (range(1,50) as $index){
            DB::table('donations')->insert([
                'amount_donated' => $faker -> numberBetween(500000, 1000000),
                'donor_ID' => $faker -> randomElement($donors),
                'donation_month' => $faker ->date('d-m-Y'),
                'administrator_ID' => $faker -> randomElement($admins),
            ]);
        }

        $category = array("Symptomatic", "Asymptomatic");
        $gendar = array("M", "F");
        $case_type = array("postive", "false positive");

        foreach (range(1,100) as $index){
            DB::table('patients')->insert([
                'patient_name' => $faker ->firstName,
                'date_of_identification' => $faker -> date(),
                'category' => $faker -> randomElement($category),
                'gender' => $faker ->  randomElement($gendar),
                'case_type' => $faker -> randomElement($case_type),
            ]);
        }


        $category = array("Private", "Public");
        $class = array("National Referral", "Regional Referral", "General");
        $postion = array("Head", "Superintendent", "Director");


        foreach (range(1, 50) as $index) {
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
            ]);

        }

        $heads = Hospital::all()->pluck('head_ID')->toArray();
        $patients = \App\Models\Patient::all()->pluck('patient_ID')->toArray();


        $postion = array("Health Officer", "Senior health Officer", "Consultant");
        foreach (range(1,100) as $index){
            DB::table('officers')->insert([
                'officer_name' => $faker -> firstName,
                'waiting' => $faker ->boolean,
                'password' => $faker -> password,
                'officer_position' => $faker -> randomElement($postion),
                'head_ID' => $faker -> randomElement($heads),
                'administrator_ID' => $faker -> randomElement($admins),
            ]);
        }

        $officers = \App\Models\Officer::all()->pluck('officer_ID')->toArray();
        foreach (range(1,100) as $index){
            DB::table('officer_patients')->insert([
                'officer_ID' => $faker ->randomElement($officers),
                'patient_ID' => $faker -> randomElement($patients),
            ]);
        }
    }

}
