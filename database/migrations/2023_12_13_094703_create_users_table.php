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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('email');
            $table->string('password');
            $table->text('user_pp')->nullable();
            $table->date('registered_at')->useCurrent();
            $table->text('pass_unhashed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
