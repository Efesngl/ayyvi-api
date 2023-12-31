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
        Schema::table('sign_reason_likes', function (Blueprint $table) {
            $table->foreign(['user_id'], 'sign_reason_likes_ibfk_2')->references(['ID'])->on('users')->onDelete('CASCADE');
            $table->foreign(['reason_id'], 'sign_reason_likes_ibfk_3')->references(['ID'])->on('sign_reasons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sign_reason_likes', function (Blueprint $table) {
            $table->dropForeign('sign_reason_likes_ibfk_2');
            $table->dropForeign('sign_reason_likes_ibfk_3');
        });
    }
};
