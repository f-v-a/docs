<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegulatoryTaskController extends Controller
{
    public function show() {
        
        return view('regulatory-task.store');
    }
}
