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
            $table->string('login', 100)->unique();
            $table->string('password');
            $table->foreignId('role_id')->references('id')->on('roles');
            $table->string('surname', 150);
            $table->string('name', 150);
            $table->string('patronymic', 150)->nullable();
            $table->foreignId('position_id')->nullable()->references('id')->on('positions');
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
