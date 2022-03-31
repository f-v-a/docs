@extends('layouts.main_layout')

@section('title', 'Оборудование')

    @if (Route::currentRouteName() == 'active.index')
        @section('page-title', 'Оборудования')
    @endif
    @if (Route::currentRouteName() == 'decommissioned.index')
        @section('page-title', 'Выведенное из эксплуатации')
    @endif
    @if (Route::currentRouteName() == 'written-off.index')
        @section('page-title', 'Списанное')
    @endif

@section('content')

    @if (Route::currentRouteName() == 'active.index')
        @livewire('tables.equipments-table')
    @endif
    @if (Route::currentRouteName() == 'decommissioned.index')
        @livewire('tables.decommissioned-equipment-table')
    @endif
    @if (Route::currentRouteName() == 'written-off.index')
        @livewire('tables.written-off-equipment-table')
    @endif
    <x-notifications z-index="z-50" />

@endsection