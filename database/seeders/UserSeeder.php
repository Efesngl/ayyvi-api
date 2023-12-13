<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for($i=1;$i<=100;$i++){
            $pass=fake()->randomNumber(8);
            DB::table("users")->insert([
                "firstname"=>fake()->firstName(),
                "lastname"=>fake()->lastName(),
                "email"=>fake()->email(),
                "password"=>Hash::make($pass),
                "pass_unhased"=>$pass,
                "user_pp"=>"/img/user_logos/1.jpg",
            ]);
        }
    }
}
