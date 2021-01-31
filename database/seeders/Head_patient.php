<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Head_patient extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $officers = \App\Models\Hospital::all()->pluck('head_ID')->toArray();
        $patients = \App\Models\Patient::all()->pluck('patient_ID')->toArray();
        foreach (range(1,20) as $index){
            DB::table('head_patients')->insert([
                'head_ID' => $faker ->randomElement($officers),
                'patient_ID' => $faker -> randomElement($patients),
            ]);
        }
    }
}
