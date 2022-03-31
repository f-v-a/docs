<?php

namespace App\Http\Controllers;

use App\Models\IncidentStatus;
use Illuminate\Http\Request;

class IncidentStatusController extends Controller
{
    public function index () {
        $statuses = IncidentStatus::get();

        return view('incident_statuses', compact('statuses'));
    }

    public function store(Request $request) {
        $request->validate([
            'name'=>'required|unique:incident_statuses'
        ]);

        $newStatus = IncidentStatus::create([
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
            'status' => IncidentStatus::find($id),
            'statuses' => IncidentStatus::get()
        ];

        return view('incident_statuses', $data);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|unique:incident_statuses'
        ]);

        $updatedStatus = IncidentStatus::find($id)->update($request->all());

        if ($updatedStatus) {
            return redirect()->route('conditions.incidents.index')->with('success','Данные успешно обновлены');
        }
        else {
            return back()->with('fail','Что-то пошло не так');
        }
    }

    public function destroy($id) {
        $deleteStatus = IncidentStatus::find($id)->delete();
        
        if ($deleteStatus) {
            return redirect()->route('conditions.incidents.index')->with('success','Данные успешно удалены');
        }
        else {
            return back()->with('fail','Что-то пошло не так');
        }
    }
}
