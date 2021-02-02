<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Donation extends Seeder
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
        $donors = \App\Models\Donor::all()->pluck('donor_ID')->toArray();
        $class = array("", "Regional Referral", "General");
        foreach (range(1,50) as $index){
            DB::table('donations')->insert([
                'donation_month' => $faker ->date('d-m-Y'),
                'amount_donated' => $faker -> numberBetween(500000, 1000000),
                'donor_ID' => $faker -> randomElement($donors),
                'administrator_ID' => $faker -> randomElement($admins),
            ]);
        }
    }
}
