<?php

namespace Database\Seeders;

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
        foreach (range(1,10) as $index){
            DB::table('patients')->insert([
                'patient_name' => $faker ->firstName,
                'Date_of_identification' => $faker ->date("d-m-Y"),
                'category' => $faker ->name,
                'Gender' => $faker -> titleMale,
                'Case_type' => $faker ->title,
            ]);
        }

    }
}
