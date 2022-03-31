<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->references('id')->on('equipment');
            $table->foreignId('executor_id')->nullable()->references('id')->on('executors');
            $table->foreignId('creator_id')->references('id')->on('employees');
            $table->text('description');
            $table->string('condition', 100);
            $table->string('influence', 100);
            $table->date('date_completion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidents');
    }
}
