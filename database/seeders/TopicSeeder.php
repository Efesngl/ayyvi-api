<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics= [
            "Aile",
            "Ekonomi",
            "Hayvan hakları",
            "Adalet",
            "Kadın hakları",
            "Eğitim",
            "Eğlence",
            "Engellier",
            "İnsan hakları",
            "Siyaset",
            "İnternet",
            "Lgbtq hakları",
            "Çevre"
        ];
        foreach ($topics as $t) {
            # code...
            DB::table("topics")->insert([
                "topic"=>$t
            ]);
        }
    }
}
