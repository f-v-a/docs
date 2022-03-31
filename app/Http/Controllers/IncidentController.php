<?php

namespace App\Http\Controllers;

use App\Models\CurrentCondition;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Executor;
use App\Models\Incident;
use App\Models\IncidentStatus;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function index() {

        return view('incidents.incidents');
    }

    // public function create() {
    //     $directories = [
    //         'employees' =>Employee::get(),
    //         'executors' =>Executor::get(),
    //         'equipments' =>Equipment::get(),
    //     ];

    //     return view('add.incident', $directories);
    // }

    // public function store(Request $request) {
    //     $request->validate([
    //         'description'=>'required',
    //         'creator_id'=>'required',
    //         'executor_id'=>'required',
    //         'influence'=>'required',
    //         'equipment_id'=>'required',
    //     ]);

    //     $query = Incident::create([
    //         'description'=>$request->input('description'),
    //         'creator_id'=>Employee::where('surname', $request->input('creator_id'))->value('id'),
    //         'executor_id'=>Executor::where('surname', $request->input('executor_id'))->value('id'),
    //         'influence'=>$request->input('influence'),
    //         'equipment_id'=>Equipment::where('name', $request->input('equipment_id'))->value('id'),
    //         'condition'=>'Согласование с глав врачом'
    //     ]);

    //     if ($query) {
    //         return back()->with('success','Данные успешно добавлены');
    //     }
    //     else {
    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }
}
