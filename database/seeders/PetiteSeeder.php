<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Testing\Fakes\Fake;

class PetiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for($i=0;$i<15;$i++){
            DB::table("signed_petites")->insert([
                "user_id"=>fake()->numberBetween(1,102),
                "petite_id"=>31,
            ]);
        }
    }
}
