<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index () {
        // $employees = Employee::get();
        
        return view('staff.employees');
    }

    // public function create() {
    //     $positions = Position::get();

    //     return view('add.employee', compact('positions'));
    // }

    // public function store(Request $request) {
    //     $request->validate([
    //         'surname'=>'required',
    //         'name'=>'required',
    //         'position_id'=>'required',
    //         'gender'=>'required',
    //         'birthday'=>'required'
    //     ]);

    //     $newEmployee = Employee::create([
    //         'surname'=>$request->input('surname'),
    //         'name'=>$request->input('name'),
    //         'patronymic'=>$request->input('patronymic'),
    //         'position_id'=>Position::where('name', $request->input('position_id'))->value('id'),
    //         'gender'=>$request->input('gender'),
    //         'birthday'=>$request->input('birthday'),
    //         'telephone'=>$request->input('telephone'),
    //         'email'=>$request->input('email'),
    //         'cabinet_number'=>$request->input('cabinet_number'),
    //     ]);

    //     if ($newEmployee) {
            
    //         return back()->with('success','Данные успешно добавлены');
    //     }
    //     else {

    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }

    // public function edit($id) {
    //     $dataEmployees = [
    //         'employee' => Employee::find($id),
    //         'positions' => Position::get()
    //     ];

    //     return view('edit.employee', $dataEmployees);
    // }

    // public function update(Request $request, $id) {
    //     $request->validate([
    //         'surname'=>'required',
    //         'name'=>'required',
    //         'position_id'=>'required',
    //         'gender'=>'required',
    //         'birthday'=>'required'
    //     ]);

    //     $updatedEmployee = Employee::find($id)->update([
    //         'surname'=>$request->input('surname'),
    //         'name'=>$request->input('name'),
    //         'patronymic'=>$request->input('patronymic'),
    //         'position_id'=>Position::where('name', $request->input('position_id'))->value('id'),
    //         'gender'=>$request->input('gender'),
    //         'birthday'=>$request->input('birthday'),
    //         'telephone'=>$request->input('telephone'),
    //         'email'=>$request->input('email'),
    //         'cabinet_number'=>$request->input('cabinet_number'),
    //     ]);

    //     if ($updatedEmployee) {

    //         return redirect()->route('employees.index')->with('success','Данные успешно обновлены');
    //     }
    //     else {

    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }
}
