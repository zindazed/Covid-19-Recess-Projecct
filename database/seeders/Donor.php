<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Donor extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        $admins = \App\Models\User::all()->pluck('id')->toArray();
        foreach (range(1,5) as $index){
            DB::table('donors')->insert([
                'donor_name' => $faker -> name,
                'administrator_ID' => $faker -> randomElement($admins),
                'created_at' => $faker -> date('Y-m-d H:i:s'),
                'updated_at' => $faker -> date('Y-m-d H:i:s')
            ]);
        }

    }
}
