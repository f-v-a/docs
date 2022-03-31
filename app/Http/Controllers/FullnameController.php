<?php

namespace App\Http\Controllers;

use App\Models\Fullname;
use App\Models\Position;
use Illuminate\Http\Request;

class FullnameController extends Controller
{
    public function index () {

        return view('directories.fullname');
    }

    // public function store(Request $request) {
    //     $request->validate([
    //         'name'=>'required',
    //         'surname'=>'required'
    //     ]);

    //     $newName = Fullname::create([
    //         'name'=>$request->input('name'),
    //         'surname'=>$request->input('surname'),
    //         'patronymic'=>$request->input('patronymic'),
    //         'position_id'=>Position::where('name', $request->input('position_id'))->value('id')
    //     ]);

    //     if ($newName) {
    //         return back()->with('success','Данные успешно добавлены');
    //     }
    //     else {
    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }

    // public function edit($id) {
    //     $data = [
    //         'fullname' => Fullname::find($id),
    //         'fullnames' => Fullname::get(),
    //         'positions' => Position::get()
    //     ];

    //     return view('fullname', $data);
    // }

    // public function update(Request $request, $id) {
    //     $request->validate([
    //         'name'=>'required',
    //         'surname'=>'required'
    //     ]);

    //     $updatedName = Fullname::find($id)->update([
    //         'name'=>$request->input('name'),
    //         'surname'=>$request->input('surname'),
    //         'patronymic'=>$request->input('patronymic'),
    //         'position_id'=>Position::where('name', $request->input('position_id'))->value('id')
    //     ]);

    //     if ($updatedName) {
    //         return redirect()->route('fullnames.index')->with('success','Данные успешно обновлены');
    //     }
    //     else {
    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }

    // public function destroy($id) {
    //     $deleteName = Fullname::find($id)->delete();
        
    //     if ($deleteName) {
    //         return redirect()->route('fullnames.index')->with('success','Данные успешно удалены');
    //     }
    //     else {
    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }
}
