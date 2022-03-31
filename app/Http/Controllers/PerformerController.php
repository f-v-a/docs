<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\Executor;
use Illuminate\Http\Request;

class PerformerController extends Controller
{
    public function index() {
        // $performers = Executor::get();

        return view('staff.company.performers');
    }

    // public function create() {
    //     $contractors = Contractor::get();

    //     return view('add.performer', compact('contractors'));
    // }

    // public function store (Request $request) {
    //     $request->validate([
    //         'name'=>'required',
    //         'surname'=>'required',
    //         'contractor_id'=>'required',
    //         'position'=>'required'
    //     ]);

    //     $newPerformer = Executor::create([
    //         'contractor_id' => Contractor::where('name', $request->input('contractor_id'))->value('id'),
    //         'name' => $request->input('name'),
    //         'surname' => $request->input('surname'),
    //         'patronymic' => $request->input('surname'),
    //         'position' => $request->input('position'),
    //         'telephone' => $request->input('telephone'),
    //         'email' => $request->input('email')
    //     ]);
        
    //     if ($newPerformer) {
    //         return back()->with('success','Данные успешно добавлены');
    //     }
    //     else {
    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }
}
