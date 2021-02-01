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
        $category = array("Symptomatic", "Asymptomatic");
        $gendar = array("M", "F");
        $case_type = array("postive", "false positive");
        $officers = \App\Models\Officer::all()->pluck('officer_Id')->toArray();
        $admin = \App\Models\User::all()->pluck('id')->toArray();
        $category = array("Private", "Public");
        $class = array("National Referral", "Regional Referral", "General");
        $postion = array("Health Officer", "Senior health Officer", "Consultant");
        $admins = \App\Models\User::all()->pluck('id')->toArray();
        $hospitals = Hospital::all()->pluck('head_ID')->toArray();
        $category = array("Private", "Public");
        $class = array("National Referral", "Regional Referral", "General");
        $postion = array("Health Officer", "Senior health Officer", "Consultant");

        foreach (range(1,3) as $index){
            DB::table('users')->insert([
                'name' => $faker -> name,
                'email' => $faker ->email,
                'email_verified_at' => $faker -> date(),
                'password' => $faker -> password,
                'is_admin' => $faker -> boolean,
                'monthly_payment' => $faker -> numberBetween(50, 100),
            ]);
        }

<<<<<<< HEAD


        foreach (range(1,20) as $index){
            DB::table('donors')->insert([
                'donor_name' => $faker -> name,
                'donation_month' => $faker ->month,
                'amount_donated' => $faker -> numberBetween(50, 100),
                'administrator_ID' => $faker -> randomElement($admins),
            ]);
        }


=======
        $category = array("Symptomatic", "Asymptomatic");
        $gendar = array("M", "F");
        $case_type = array("postive", "false positive");
>>>>>>> d76e8e72eb9d6662c22411f617a2fb0e6d12c8ff
        foreach (range(1,20) as $index){
            DB::table('patients')->insert([
                'patient_name' => $faker ->firstName,
                'date_of_identification' => $faker -> date(),
                'category' => $faker -> randomElement($category),
                'gender' => $faker ->  randomElement($gendar),
                'case_type' => $faker -> randomElement($case_type),
            ]);
        }

<<<<<<< HEAD
=======
        $admins = \App\Models\User::all()->pluck('id')->toArray();
        foreach (range(1,20) as $index){
            DB::table('donors')->insert([
                'donor_name' => $faker -> name,
                'donation_month' => $faker ->month,
                'amount_donated' => $faker -> numberBetween(50, 100),
                'administrator_ID' => $faker -> randomElement($admins),
            ]);
        }

        $category = array("Private", "Public");
        $class = array("National Referral", "Regional Referral", "General");
        $postion = array("Health Officer", "Senior health Officer", "Consultant");
>>>>>>> d76e8e72eb9d6662c22411f617a2fb0e6d12c8ff


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
                'administrator_ID' => $faker->randomElement($admins),
            ]);

<<<<<<< HEAD


            foreach (range(1,200) as $index){
                DB::table('officers')->insert([
                    'officer_name' => $faker -> firstName,
                    'waiting' => $faker ->boolean,
                    'monthly_payment' => $faker -> numberBetween(50, 100),
                    'award_payment' => $faker -> numberBetween(50, 100),
                    'password' => $faker -> password,
                    'officer_position' => $faker -> randomElement($postion),
                    'head_ID' => $faker -> randomElement($hospitals),
                    'administrator_ID' => $faker -> randomElement($admins),
                ]);
            }

//            $officers = \App\Models\Officer::all()->pluck('officer_ID')->toArray();
//            $patients = \App\Models\Patient::all()->pluck('patient_ID')->toArray();
//            foreach (range(1,300) as $index){
//                DB::table('officer_patients')->insert([
//                    'officer_ID' => $faker ->randomElement($officers),
//                    'patient_ID' => $faker -> randomElement($patients),
//                ]);
//            }

=======
        }

        $heads = Hospital::all()->pluck('head_ID')->toArray();
        $patients = \App\Models\Patient::all()->pluck('patient_ID')->toArray();
        foreach (range(1,20) as $index){
            DB::table('head_patients')->insert([
                'head_ID' => $faker ->randomElement($heads),
                'patient_ID' => $faker -> randomElement($patients),
            ]);
        }

        foreach (range(1,20) as $index){
            DB::table('officers')->insert([
                'officer_name' => $faker -> firstName,
                'waiting' => $faker ->boolean,
                'monthly_payment' => $faker -> numberBetween(50, 100),
                'award_payment' => $faker -> numberBetween(50, 100),
                'password' => $faker -> password,
                'officer_position' => $faker -> randomElement($postion),
                'head_ID' => $faker -> randomElement($heads),
                'administrator_ID' => $faker -> randomElement($admins),
            ]);
        }

        $officers = \App\Models\Officer::all()->pluck('officer_ID')->toArray();
        foreach (range(1,20) as $index){
            DB::table('officer_patients')->insert([
                'officer_ID' => $faker ->randomElement($officers),
                'patient_ID' => $faker -> randomElement($patients),
            ]);
>>>>>>> d76e8e72eb9d6662c22411f617a2fb0e6d12c8ff
        }

    }
}
