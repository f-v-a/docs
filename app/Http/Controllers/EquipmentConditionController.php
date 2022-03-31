<?php

namespace App\Http\Controllers;

use App\Models\Equipment_condition;
use Illuminate\Http\Request;


class EquipmentConditionController extends Controller
{
    public function index () {
        $equipmentStatuses = Equipment_condition::get();

        return view('equipment_condition', compact('equipmentStatuses'));
    }

    public function store(Request $request) {
        $request->validate([
            'name'=>'required|unique:equipment_conditions'
        ]);

        $newStatus = Equipment_condition::create([
            'name'=>$request->input('name')
        ]);

        if ($newStatus) {
            return back()->with('success','Данные успешно добавлены');
        }
        else {
            return back()->with('fail','Что-то пошло не так');
        }
    }

    public function edit($id) {
        $data = [
            'equipmentStatus' => Equipment_condition::find($id),
            'equipmentStatuses' => Equipment_condition::get()
        ];

        return view('equipment_condition', $data);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|unique:equipment_conditions'
        ]);

        $updatedStatus = Equipment_condition::find($id)->update($request->all());

        if ($updatedStatus) {
            return redirect()->route('conditions.equipments.index')->with('success','Данные успешно обновлены');
        }
        else {
            return back()->with('fail','Что-то пошло не так');
        }
    }

    public function destroy($id) {
        $deleteStatus = Equipment_condition::find($id)->delete();
        
        if ($deleteStatus) {
            return redirect()->route('conditions.equipments.index')->with('success','Данные успешно удалены');
        }
        else {
            return back()->with('fail','Что-то пошло не так');
        }
    }
}
