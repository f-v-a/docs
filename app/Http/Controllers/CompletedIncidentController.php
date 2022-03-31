<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompletedIncidentController extends Controller
{
    public function index() {
        // $data = array(
        //     'completed_incident_list' => DB::table('incidents')
        //     ->leftJoin('current_conditions', 'current_conditions.id', '=', 'incidents.influence_id')
        //     ->leftJoin('equipment', 'equipment.id', '=', 'incidents.equipment_id')
        //     ->leftJoin('executors', 'executors.id', '=', 'incidents.executor_id')
        //     ->leftJoin('employees', 'employees.id', '=', 'incidents.creator_id')
        //     ->leftJoin('incident_statuses', 'incident_statuses.id', '=', 'incidents.status_id')
        //     ->select('incidents.*', 'current_conditions.name as current_condition',
        //     'equipment.name as equipment_name', 'executors.surname as ex_surname',
        //     'executors.name as ex_name','employees.surname as creator_surname',
        //     'employees.name as creator_name', 'incident_statuses.name as status')
        //     ->where('incident_statuses.name', '=', 'Завершен')
        //     ->get()

            // FIXME:'incident_list' => Incident::with('current_conditions')->get() https://laravel.com/docs/5.2/eloquent-relationships#eager-loading
            // можно сделать лучше если посмотреть доки и добавить в модель функцию связи между таблицами.
        // );
        
        return view('incidents.incidents');
    }

    // public function search(Request $request) {
    //     if(!empty($request->input('query'))) {
    //         $searchText = $_GET['query'];
    //         $result = DB::table('incidents')
    //         ->leftJoin('current_conditions', 'current_conditions.id', '=', 'incidents.influence_id')
    //         ->leftJoin('equipment', 'equipment.id', '=', 'incidents.equipment_id')
    //         ->leftJoin('executors', 'executors.id', '=', 'incidents.executor_id')
    //         ->leftJoin('employees', 'employees.id', '=', 'incidents.creator_id')
    //         ->leftJoin('incident_statuses', 'incident_statuses.id', '=', 'incidents.status_id')
    //         ->select('incidents.*', 'current_conditions.name as current_condition',
    //         'equipment.name as equipment_name', 'executors.surname as ex_surname',
    //         'executors.name as ex_name','employees.surname as creator_surname',
    //         'employees.name as creator_name', 'incident_statuses.name as status')
    //         ->where('equipment.name', 'LIKE', '%'.$searchText.'%' )
    //         ->where('incident_statuses.name', '=', 'Завершен')
    //         ->paginate();

    //         return view('completed_incident', ['search_result'=> $result]);
    //     }
    //     else {
    //         return redirect()->route('completed-incidents.index');
    //     }
    // }
}
