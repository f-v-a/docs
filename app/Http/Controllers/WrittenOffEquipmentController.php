<?php

namespace App\Http\Controllers;

use App\Models\Equipment;

class WrittenOffEquipmentController extends Controller
{
    public function index() {
        // $equipments = Equipment::leftJoin('equipment_conditions', 'equipment_conditions.id', '=', 'equipment.condition_id')
        // ->where('equipment_conditions.name', '=', 'Списано')
        // ->get();
        
        return view('equipments.equipments');
    }
}
