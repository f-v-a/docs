<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;


class PositionController extends Controller
{
    public function index () {

        return view('directories.positions');
    }

    // public function store(Request $request) {
    //     $request->validate([
    //         'name'=>'required|unique:positions'
    //     ]);

    //     $newPositions = Position::create([
    //         'name'=>$request->input('name')
    //     ]);

    //     if ($newPositions) {
    //         return back()->with('success','Данные успешно добавлены');
    //     }
    //     else {
    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }

    // public function edit($id) {
    //     $data = [
    //         'position' => Position::find($id),
    //         'positions' => Position::get()
    //     ];

    //     return view('position', $data);
    // }

    // public function update(Request $request, $id) {
    //     $request->validate([
    //         'name' => 'required|unique:positions'
    //     ]);

    //     $updatedPosition = Position::find($id)->update($request->all());

    //     if ($updatedPosition) {
    //         return redirect()->route('positions.index')->with('success','Данные успешно обновлены');
    //     }
    //     else {
    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }

    // public function destroy($id) {
    //     $deletePosition = Position::find($id)->delete();
        
    //     if ($deletePosition) {
    //         return redirect()->route('positions.index')->with('success','Данные успешно удалены');
    //     }
    //     else {
    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }
}
