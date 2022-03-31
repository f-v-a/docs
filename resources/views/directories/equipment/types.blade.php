@extends('layouts.main_layout')

@section('title', 'Типы оборудований')
@section('page-title', 'Типы оборудований')

@section('content')
    
    @livewire('tables.types-table')
    <x-notifications z-index="z-50" />

@endsection