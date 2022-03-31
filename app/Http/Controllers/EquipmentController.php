<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Equipment_condition;
use App\Models\EquipmentModel;
use App\Models\EquipmentType;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipmentController extends Controller
{

    public function index() {
        // $equipments = Equipment::leftJoin('equipment_conditions', 'equipment_conditions.id', '=', 'equipment.condition_id')
        // ->where('equipment_conditions.name', '!=', 'Выведено из эксплуатации')
        // ->where('equipment_conditions.name', '!=', 'Списано')
        // ->get();
    
        return view('equipments.equipments');
    }

    // public function create() {
    //     $equipmentName = [
    //         'types' => EquipmentType::get(),
    //         'models' => EquipmentModel::get(),
    //         'manufacturers' => Manufacturer::get(),
    //     ];

    //     return view('add.equipment', $equipmentName);
    // }

    // public function store(Request $request) {
    //     $request->validate([
    //         'name'=>'required',
    //         'description'=>'required',
    //         'type_id'=>'required',
    //         'model_id'=>'required',
    //         'manufacturer_id'=>'required',
    //         'price'=>'required',
    //         'serial_number'=>'required|unique:equipment',
    //         'manufacture_date'=>'date',
    //         'buy_date'=>'date',
    //         'commissioning_date'=>'date'
    //     ]);

    //     $query = Equipment::create([
    //         'name'=>$request->input('name'),
    //         'description'=>$request->input('description'),
    //         'type_id'=>EquipmentType::where('name', $request->input('type_id'))->value('id'),
    //         'model_id'=>EquipmentModel::where('name', $request->input('model_id'))->value('id'),
    //         'manufacturer_id'=>Manufacturer::where('name', $request->input('manufacturer_id'))->value('id'),
    //         'cabinet_number'=>$request->input('cabinet_number'),
    //         'price'=>$request->input('price'),
    //         'serial_number'=>$request->input('serial_number'),
    //         'manufacture_date'=>$request->input('manufacture_date'),
    //         'buy_date'=>$request->input('buy_date'),
    //         'commissioning_date'=>$request->input('commissioning_date'),
    //         'warranty_period'=>$request->input('warranty_period'),
    //         'condition_id'=> Equipment_condition::where('name', 'В работе')->value('id')
    //     ]);

    //     if ($query) {
    //         return back()->with('success','Данные успешно добавлены');
    //     }
    //     else {
    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }

    // public function edit($id) {

    //     $equipmentEdit = [
    //         'editable_equipment' => Equipment::find($id),
    //         'types' => EquipmentType::get(),
    //         'models' => EquipmentModel::get(),
    //         'manufacturers' => Manufacturer::get(),
    //     ];

    //     return view('edit.equipment', $equipmentEdit);
    // }

    // public function update(Request $request, $id) {
    //     $request->validate([
    //         'name'=>'required',
    //         'description'=>'required',
    //         'type_id'=>'required',
    //         'model_id'=>'required',
    //         'manufacturer_id'=>'required',
    //         'price'=>'required',
    //         'serial_number'=>'required|unique:equipment',
    //         'manufacture_date'=>'date',
    //         'buy_date'=>'date',
    //         'commissioning_date'=>'date'
    //     ]);

    //     $equipment = Equipment::find($id)->update($request->all());

    //     if ($equipment) {
    //         return redirect()->route('equipment.index')->with('success','Данные успешно обновлены');
    //     }
    //     else {
    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }

    // public function search() {
        
    // }
}
