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
        Schema::create('sign_reasons', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->integer('reason_id')->index('sign_reasons_ibfk_1');
            $table->string('reason', 200);
            $table->boolean('will_reason_showed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sign_reasons');
    }
};
