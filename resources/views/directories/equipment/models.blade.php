@extends('layouts.main_layout')

@section('title', 'Модели оборудований')
@section('page-title', 'Модели оборудований')

@section('content')

    @livewire('tables.models-table')
    <x-notifications z-index="z-50" />

@endsection

