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
            $table->id();
            $table->foreignId('position_id')->nullable()->references('id')->on('positions');
            $table->foreignId('role_id')->references('id')->on('roles');
            $table->string('login', 100)->unique();
            $table->string('password');
            $table->string('surname', 150);
            $table->string('name', 150);
            $table->string('patronymic', 150)->nullable();
            $table->string('phone', 11)->nullable()->unique();
            $table->string('email', 100)->nullable()->unique();
            $table->rememberToken();
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
