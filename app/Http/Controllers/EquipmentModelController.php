<?php

namespace App\Http\Controllers;

use App\Models\EquipmentModel;
use App\Models\EquipmentType;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Monarobase\CountryList\CountryListFacade;

class EquipmentModelController extends Controller
{
    public function index () {
        // $equipmentParts = [
        //     'models' => EquipmentModel::get(),
        //     'types' => EquipmentType::get(),
        //     'manufacturers' => Manufacturer::get()
        // ];
        return view('directories.equipment.models');
    }

    // public function store(Request $request) {
    //     $request->validate([
    //         'name'=>'required|unique:equipment_models',
    //         'type_id' =>'required',
    //         'manufacturer_id'=>'required'
    //     ]);

    //     $newModels = EquipmentModel::create([
    //         'name'=>$request->input('name'),
    //         'type_id'=>EquipmentType::where('name', $request->input('type_id'))->value('id'),
    //         'manufacturer_id'=>Manufacturer::where('name', $request->input('manufacturer_id'))->value('id')
    //     ]);

    //     if ($newModels) {
            
    //         return back()->with('success','Данные успешно добавлены');
    //     }
    //     else {

    //         return back()->with('fail','Что-то пошло не так');
    //     }

    // }

    // public function edit($id) {
    //     $data = [
    //         'model' => EquipmentModel::find($id),
    //         'models' => EquipmentModel::get()
    //     ];

    //     return view('equipment_models', $data);
    // }

    // public function update(Request $request, $id) {
    //     $request->validate([
    //         'name' => 'required|unique:equipment_models'
    //     ]);

    //     $updatedModel = EquipmentModel::find($id)->update($request->all());

    //     if ($updatedModel) {

    //         return redirect()->route('models.index')->with('success','Данные успешно обновлены');
    //     }
    //     else {

    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }

    // public function destroy($id) {
    //     $deleteModel = EquipmentModel::find($id)->delete();
        
    //     if ($deleteModel) {

    //         return redirect()->route('models.index')->with('success','Данные успешно удалены');
    //     }
    //     else {

    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }
}
