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

        $admins = \App\Models\Administrator::all()->pluck('administrator_ID')->toArray();
        foreach (range(1,10) as $index){
            DB::table('donors')->insert([
                'donor_name' => $faker -> name,
                'donation_month' => $faker ->month,
                'amount_donated' => $faker -> numberBetween(50, 100),
                'administrator_ID' => $faker -> randomElement($admins),
            ]);
        }
    }
}
