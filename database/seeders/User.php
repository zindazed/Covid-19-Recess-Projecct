<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1,2) as $index){
            DB::table('users')->insert([
                'name' => $faker -> name,
                'email' => $faker ->email,
                'email_verified_at' => $faker -> date(),
                'password' => $faker -> password,
                'position' => "Administrator",
                'created_at' => $faker -> date('Y-m-d H:i:s'),
                'updated_at' => $faker -> date('Y-m-d H:i:s')
            ]);
        }
    }
}
