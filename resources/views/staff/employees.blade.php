@extends('layouts.main_layout')

@section('title', 'Сотрудники')
@section('page-title', 'Сотрудники')

@section('content')

    @livewire('tables.employee-table')
    <x-notifications z-index="z-50" />

@endsection