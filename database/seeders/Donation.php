<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        foreach (range(1,1) as $index){
            DB::table('donations')->insert([
                'donation_month' => $faker ->date('d-m-Y'),
                'amount_donated' => 1000,
                'donor_ID' => $faker -> randomElement($donors),
                'administrator_ID' => $faker -> randomElement($admins),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),//date('Y-m-d H:i:s')
            ]);
        }
    }
}
