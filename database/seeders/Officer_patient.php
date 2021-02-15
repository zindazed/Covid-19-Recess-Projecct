<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        $officers = DB::table("officers")
            ->select("*")
            ->where("Retired", "=","0")
            ->pluck('officer_ID')->toArray();
        $patients = \App\Models\Patient::all()->pluck('patient_ID')->toArray();
        foreach (range(1,100) as $index) {
            DB::table('officer_patients')->insert([
                'officer_ID' => $faker->randomElement($officers),
                'patient_ID' => $faker->randomElement($patients),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),//$faker->date('Y-m-d H:i:s'),
            ]);
        }
    }
}
