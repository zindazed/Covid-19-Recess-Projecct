<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Officer_patient extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $officers = \App\Models\Officer::all()->pluck('officer_ID')->toArray();
        $patients = \App\Models\Patient::all()->pluck('patient_ID')->toArray();
        foreach (range(1,20) as $index) {
            DB::table('officer_patients')->insert([
                'officer_ID' => $faker->randomElement($officers),
                'patient_ID' => $faker->randomElement($patients),
                'created_at' => $faker->date('Y-m-d H:i:s'),
                'updated_at' => $faker->date('Y-m-d H:i:s'),
            ]);
        }
    }
}
