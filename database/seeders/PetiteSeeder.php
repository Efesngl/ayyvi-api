<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Testing\Fakes\Fake;

class petitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for($i=0;$i<15;$i++){
            DB::table("signed_petitions")->insert([
                "user_id"=>fake()->numberBetween(1,102),
                "petition_id"=>31,
            ]);
        }
    }
}
