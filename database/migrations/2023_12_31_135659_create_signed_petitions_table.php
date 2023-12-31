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
        Schema::create('signed_petitions', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->integer('user_id')->index('signed_petitions_ibfk_4');
            $table->integer('petition_id')->index('signed_petitions_ibfk_3');
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
        Schema::dropIfExists('signed_petitions');
    }
};
