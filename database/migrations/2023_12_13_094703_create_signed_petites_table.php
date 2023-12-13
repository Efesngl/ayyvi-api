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
        Schema::create('signed_petites', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->integer('user_id')->index('user_id');
            $table->integer('petite_id')->index('petite_id');
            $table->date('signed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signed_petites');
    }
};
