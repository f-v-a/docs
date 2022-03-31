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

    
            foreach($equipmentType as $type) {
                DB::table('equipment_types')->insert([
                    'name' => $type
                ]);
            }

            foreach($equipmentModels as $key => $model) {
                DB::table('equipment_models')->insert([
                    'name' => $model,
                    'type_id' => $key+1,
                    'manufacturer' => 'Россия',
                ]);
        }
    }
}
