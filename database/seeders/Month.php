<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Month extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $months = array("January", "February", "March",'April','May','June','June','August','September','October','November','December');
        foreach (range(1,12) as $index){
            foreach ($months as $m){
            DB::table('months')->insert([
                'month_name' => $m,
            ]);}
        }
    }
}
