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
        Schema::table('petitions', function (Blueprint $table) {
            $table->foreign(['creator'], 'petitions_ibfk_1')->references(['ID'])->on('users');
            $table->foreign(['petition_topic'], 'petitions_ibfk_2')->references(['ID'])->on('topics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('petitions', function (Blueprint $table) {
            $table->dropForeign('petitions_ibfk_1');
            $table->dropForeign('petitions_ibfk_2');
        });
    }
};
