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
        Schema::table('sign_reasons', function (Blueprint $table) {
            $table->foreign(['reason_id'], 'sign_reasons_ibfk_1')->references(['ID'])->on('signed_petitions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sign_reasons', function (Blueprint $table) {
            $table->dropForeign('sign_reasons_ibfk_1');
        });
    }
};
