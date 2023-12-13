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
        Schema::table('signed_petites', function (Blueprint $table) {
            $table->foreign(['user_id'], 'signed_petites_ibfk_4')->references(['ID'])->on('users');
            $table->foreign(['petite_id'], 'signed_petites_ibfk_3')->references(['ID'])->on('petites');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('signed_petites', function (Blueprint $table) {
            $table->dropForeign('signed_petites_ibfk_4');
            $table->dropForeign('signed_petites_ibfk_3');
        });
    }
};
