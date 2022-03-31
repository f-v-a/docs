<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use Illuminate\Http\Request;

class ContractorController extends Controller
{
    public function index() {
        // $contractors = Contractor::get();

        return view('staff.company.contractors');
    }

    // public function create() {

    //     return view('add.contractor');
    // }

    // public function edit($id) {
    //     $contractor = Contractor::find($id);

    //     return view('edit.contractor', compact('contractor'));
    // }

    // public function store(Request $request) {
    //     $request->validate([
    //         'name'=>'required',
    //         'inn'=>'required',
    //     ]);

    //     $contractor = Contractor::create(
    //         $request->all()
    //     );

    //     if ($contractor) {
    //         return back()->with('success','Данные успешно добавлены');
    //     }
    //     else {
    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }

    // public function update(Request $request, $id) {
    //     $request->validate([
    //         'name'=>'required',
    //         'inn'=>'required',
    //     ]);

    //     $contractor = Contractor::find($id)->update($request->all());

    //     if ($contractor) {
    //         return redirect()->route('contractors.index')->with('success','Данные успешно обновлены');
    //     }
    //     else {
    //         return back()->with('fail','Что-то пошло не так');
    //     }
    // }
}
