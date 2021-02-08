<?php

namespace Database\Seeders;

use App\Models\Hospital;
use Carbon\Carbon;
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

        foreach (range(1,3) as $index){
            DB::table('users')->insert([
                'name' => $faker -> name,
                'email' => $faker ->email,
                'email_verified_at' => $faker -> date(),
                'password' => $faker -> password,
                'position' => "Administrator",
                'created_at' => Carbon::now(),//$faker -> date('Y-m-d H:i:s'),
                'updated_at' => Carbon::now(),
            ]);
        }

        $category = array("Symptomatic", "Asymptomatic");
        $gendar = array("M", "F");
        $case_type = array("postive", "false positive");

        foreach (range(1,25) as $index){
            DB::table('patients')->insert([
                'patient_name' => $faker ->firstName,
                'date_of_identification' => $faker -> date(),
                'category' => $faker -> randomElement($category),
                'gender' => $faker ->  randomElement($gendar),
                'case_type' => $faker -> randomElement($case_type),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $admins = \App\Models\User::all()->pluck('id')->toArray();
        foreach (range(1,4) as $index){
            DB::table('donors')->insert([
                'donor_name' => $faker -> name,
                'administrator_ID' => $faker -> randomElement($admins),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        $donors = \App\Models\Donor::all()->pluck('donor_ID')->toArray();
        foreach (range(1,6) as $index){
            DB::table('donations')->insert([
                'donation_month' => $faker ->date('d-m-Y'),
                'amount_donated' => $faker ->numberBetween(50,100),
                'donor_ID' => $faker -> randomElement($donors),
                'administrator_ID' => $faker -> randomElement($admins),
            ]);
        }

        $months = array("January", "February", "March",'April','May','June','July','August','September','October','November','December');
        foreach (range(1,1) as $index){
            foreach ($months as $m){
                DB::table('months')->insert([
                    'month_name' => $m,
                ]);}
        }

        $donor = \App\Models\Donor::all()->pluck('donor_ID')->toArray();
        foreach (range(1,1) as $index){
            DB::table('ids')->insert([
                'number' => $faker->randomElement($donor),
                'month' => $faker->randomElement($months),
            ]);
        }

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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $heads = Hospital::all()->pluck('head_ID')->toArray();
        $patients = \App\Models\Patient::all()->pluck('patient_ID')->toArray();


        $postion = array("Health Officer", "Senior health Officer", "Consultant");
        foreach (range(1,15) as $index){
            DB::table('officers')->insert([
                'officer_name' => $faker -> firstName,
                'password' => $faker -> password,
                'officer_position' => $faker -> randomElement($postion),
                'Retired' => 0,
                'head_ID' => $faker -> randomElement($heads),
                'administrator_ID' => $faker -> randomElement($admins),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $officers = \App\Models\Officer::all()->pluck('officer_ID')->toArray();
        foreach (range(1,25) as $index){
            DB::table('officer_patients')->insert([
                'officer_ID' => $faker ->randomElement($officers),
                'patient_ID' => $faker -> randomElement($patients),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $hospitals = DB::table("hospitals")->select("*")->get();
        foreach ($hospitals as $hospital) {
            switch ($hospital->class) {
                case 'National Referral':
                    DB::table("hospitals")
                        ->where("head_ID","=",$hospital->head_ID)
                        ->update(["officer_position" => "Director"]);
                    DB::table("officers")
                        ->where("head_ID","=",$hospital->head_ID)
                        ->update(["officer_position" => "Consultant"]);
                    break;
                case 'Regional Referral':
                    DB::table("hospitals")
                        ->where("head_ID","=",$hospital->head_ID)
                        ->update(["officer_position" => "Superintendent"]);
                    DB::table("officers")
                        ->where("head_ID","=",$hospital->head_ID)
                        ->update(["officer_position" => "Senior health Officer"]);
                    break;
                case 'General':
                    DB::table("hospitals")
                        ->where("head_ID","=",$hospital->head_ID)
                        ->update(["officer_position" => "Head"]);
                    DB::table("officers")
                        ->where("head_ID","=",$hospital->head_ID)
                        ->update(["officer_position" => "Health Officer"]);
                    break;
            }
        }

    }

}
