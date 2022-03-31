<?php

use Illuminate\Support\Facades\Route;


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
    // Route::view('regulatory.show', 'regulatory-task.store');

    Route::group(['prefix' => 'inbox'] ,function () {

        Route::view('incidents', 'incidents.incidents')->name('incidents.index');
    });
    
    Route::group(['prefix' => 'completed'] ,function () {
        
        Route::view('completed-incidents', 'incidents.incidents')->name('completed-incidents.index');
    });
    
    Route::group(['prefix' => 'control/equipments'] ,function () {

            Route::view('active', 'equipments.equipments')->name('active.index');
    
            Route::view('decommissioned', 'equipments.equipments')->name('decommissioned.index');
    
            Route::view('written-off', 'equipments.equipments')->name('written-off.index');
    });
    
    Route::group(['prefix' => 'info'] ,function () {
    
        Route::view('employees', 'staff.employees')->name('employees.index');
        
        Route::view('contractors', 'staff.company.contractors')->name('contractors.index');
        
        Route::view('performers', 'staff.company.performers')->name('performers.index');
    });
    
    
    Route::group(['prefix' => 'directory'] ,function () {
        Route::view('types', 'directories.equipment.types')->name('types.index');
    
        Route::view('models', 'directories.equipment.models')->name('models.index');
    
        Route::view('positions', 'directories.positions')->name('positions.index');
    
        Route::view('users', 'directories.users')->name('users');
    });
});