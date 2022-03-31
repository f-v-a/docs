<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('model_id')->nullable()->references('id')->on('equipment_models');
            $table->foreignId('contractor_id')->nullable()->references('id')->on('contractors');
            $table->string('status', 100);
            $table->string('cabinet_number', 5)->nullable();
            $table->double('price', 10, 2);
            $table->string('serial_number', 50)->unique();
            $table->date('manufacture_date');
            $table->date('buy_date')->nullable();
            $table->date('commissioning_date');
            $table->string('warranty_period', 3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment');
    }
}
