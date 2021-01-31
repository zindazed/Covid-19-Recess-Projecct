<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Patient extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $category = array("Symptomatic", "Asymptomatic");
        $gendar = array("M", "F");
        $case_type = array("postive", "false positive");
        foreach (range(1,20) as $index){
            DB::table('patients')->insert([
                'patient_name' => $faker ->firstName,
                'date_of_identification' => $faker -> date(),
                'category' => $faker -> randomElement($category),
                'gender' => $faker ->  randomElement($gendar),
                'case_type' => $faker -> randomElement($case_type),
            ]);
        }
    }
}
