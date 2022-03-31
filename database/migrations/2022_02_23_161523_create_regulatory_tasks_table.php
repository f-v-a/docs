<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegulatoryTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regulatory_tasks', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->foreignId('executor_id')->references('id')->on('executors');
            $table->foreignId('employee_id')->references('id')->on('employees');
            $table->foreignId('equipment_id')->references('id')->on('equipment');
            $table->string('status', 6);
            $table->date('start_date');
            $table->string('dates')->nullable();
            $table->string('periodicity', 40)->nullable();
            $table->string('end_date', 40)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regulatory_tasks');
    }
}
