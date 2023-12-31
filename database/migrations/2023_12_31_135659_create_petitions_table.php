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
        Schema::create('petitions', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->string('petition_header');
            $table->text('petition_content');
            $table->integer('petition_topic')->index('petite_topic');
            $table->date('created_at')->useCurrent();
            $table->text('petition_image');
            $table->integer('creator')->index('creator');
            $table->integer('target_sign');
            $table->boolean('is_succeded')->default(false);
            $table->boolean('is_success_allowed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('petitions');
    }
};
