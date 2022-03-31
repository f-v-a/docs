<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegulatoryTaskController extends Controller
{
    public function index() {
        
        return view('regulatory-task.store');
    }
}
