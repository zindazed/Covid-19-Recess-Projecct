<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Administrator extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,10) as $index){
            DB::table('administrators')->insert([
                'administrator_name' => $faker -> name,
                'monthly_payment' => $faker ->numberBetween(50, 100),
                'password' => $faker -> password,
            ]);
        }
    }
}
