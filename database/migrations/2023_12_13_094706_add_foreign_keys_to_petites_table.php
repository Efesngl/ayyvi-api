<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('petites', function (Blueprint $table) {
            $table->foreign(['petite_topic'], 'petites_ibfk_2')->references(['ID'])->on('topics');
            $table->foreign(['creator'], 'petites_ibfk_1')->references(['ID'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('petites', function (Blueprint $table) {
            $table->dropForeign('petites_ibfk_2');
            $table->dropForeign('petites_ibfk_1');
        });
    }
};
