<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Testing\Fakes\Fake;

class PetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for($i=0;$i<20;$i++){
            $id=fake()->numberBetween(1,104);
            $arr=[
                "user_id"=>$id,
                "petition_id"=>83
            ];
            $user=DB::table("signed_petitions");
            if($user->where($arr)->doesntExist()){
                $user->insert($arr);
            }else{
                continue;
            }
        }
    }
}
