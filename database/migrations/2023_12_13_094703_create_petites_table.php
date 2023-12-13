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
        Schema::create('petites', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->string('petite_header');
            $table->text('petite_content');
            $table->integer('petite_topic')->index('petite_topic');
            $table->date('created_at')->useCurrent();
            $table->text('petite_image');
            $table->integer('creator')->index('creator');
            $table->integer('target_sign');
            $table->boolean('is_succeded')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('petites');
    }
};
