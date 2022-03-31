@extends('layouts.main_layout')


@if (Route::currentRouteName() == 'incidents.index')
    @section('title', 'Входящие')
@endif

@if (Route::currentRouteName() == 'completed-incidents.index')
    @section('title', 'Завершенные')
@endif

    @section('page-title', 'Инциденты')

@section('content')

    @if (Route::currentRouteName() == 'incidents.index')
        @livewire('tables.incidents-table')
    @endif
    @if (Route::currentRouteName() == 'completed-incidents.index')
        @livewire('tables.completed-incidents-table')
    @endif
    <x-notifications z-index="z-50" />

@endsection