<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $equipmentType = ['Аппарат ИВЛ', 'Дозатор', 'Дефибриллятор'];
        $equipmentModels = ['АХ-20', 'АХ-50', 'АХ-80'];


        foreach ($equipmentType as $type) {
            DB::table('equipment_types')->insert([
                'name' => $type
            ]);
        }

        foreach ($equipmentModels as $key => $model) {
            DB::table('equipment_models')->insert([
                'name' => $model,
                'type_id' => $key + 1,
                'manufacturer' => 'Россия',
            ]);
        }

        DB::table('equipment')->insert([
            'description' => 'Описание',
            'name' => 'Аппарат ИВЛ АХ-20 Россия',
            'model_id' => 1,
            'cabinet_number' => '101',
            'price' => '1000000',
            'serial_number' => '965128331',
            'contractor_id' => 1,
            'manufacture_date' => '2022-04-01',
            'buy_date' => '2022-04-02',
            'commissioning_date' => '2022-04-05',
            'warranty_period' => '12',
            'status' => 'В работе',
        ]);
    }
}
