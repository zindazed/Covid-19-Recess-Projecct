<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Id extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $months = array("January", "February", "March",'April','May','June','July','August','September','October','November','December');
        $donor = \App\Models\Donor::all()->pluck('donor_ID')->toArray();
        foreach (range(1,1) as $index){
            DB::table('ids')->insert([
                'number' => $faker->randomElement($donor),
                'month' => $faker->randomElement($months),
            ]);
        }
    }
}
