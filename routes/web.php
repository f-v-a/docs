<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompletedIncidentController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\PerformerController;
use App\Http\Controllers\DecommissionedEquipmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EquipmentModelController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RegulatoryTaskController;
use App\Http\Controllers\WrittenOffEquipmentController;
use Illuminate\Support\Facades\App;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function() {
    Route::view('regulatory.show', [RegulatoryTaskController::class, 'show']);

    Route::group(['prefix' => 'inbox'] ,function () {
        Route::resource('incidents', IncidentController::class)->except('show');
    });
    
    Route::group(['prefix' => 'completed'] ,function () {
        
        Route::resource('completed-incidents', CompletedIncidentController::class)->only('index');
    });
    
    Route::group(['prefix' => 'control'] ,function () {
        Route::group(['prefix' => 'equipments'] ,function () {
    
            Route::resource('active', EquipmentController::class);
    
            Route::resource('decommissioned', DecommissionedEquipmentController::class);
    
            Route::resource('written-off', WrittenOffEquipmentController::class);
        });
    });
    
    Route::group(['prefix' => 'info'] ,function () {
    
        Route::resource('employees', EmployeeController::class)->except('show');
        
        Route::resource('contractors', ContractorController::class)->except('show');
        
        Route::resource('performers', PerformerController::class);
    });
    
    
    Route::group(['prefix' => 'directory'] ,function () {
        Route::resource('types', EquipmentTypeController::class)->except('show');
    
        Route::resource('models', EquipmentModelController::class)->except('show');
        
        Route::resource('manufacturers', ManufacturerController::class)->except('show');
    
        Route::resource('positions', PositionController::class)->except('show');
    
        Route::view('users', 'directories.users')->name('users');
    });
});

Route::view('/powergrid', 'powergrid-demo');