<?php

namespace App\Http\Controllers;

use App\Models\EquipmentType;
use Illuminate\Http\Request;

class EquipmentTypeController extends Controller
{
    public function index () {
        // $types = EquipmentType::get();

        return view('directories.equipment.types');
    }

    // public function store(Request $request) {
    //     $request->validate([
    //         'name'=>'required|unique:equipment_types'
    //     ]);

    //     $newTypes = EquipmentType::create([
    //         'name'=>$request->input('name')
    //     ]);

    //     if ($newTypes) {
    //         return back()->with('success','Данные успешно добавлены');
    //     }
    //     else {
    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }

    // public function edit($id) {
    //     $data = [
    //         'type' => EquipmentType::find($id),
    //         'types' => EquipmentType::get()
    //     ];

    //     return view('directories.equipment.types', $data);
    // }

    // public function update(Request $request, $id) {
    //     $request->validate([
    //         'name' => 'required|unique:equipment_types'
    //     ]);

    //     $updatedType = EquipmentType::find($id)->update($request->all());

    //     if ($updatedType) {
    //         return redirect()->route('types.index')->with('success','Данные успешно обновлены');
    //     }
    //     else {
    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }

    public function destroy($id) {
        $deleteType = EquipmentType::find($id)->delete();
        
        // if ($deleteType) {
        //     return redirect()->route('types.index')->with('success','Данные успешно удалены');
        // }
        // else {
        //     return back()->with('fail','Что-то пошло не так');
        // }
    }
}
