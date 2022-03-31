@extends('layouts.main_layout')

@section('title', 'Должности')
@section('page-title', 'Должности')

@section('content')

    @livewire('tables.positions-table')
    <x-notifications z-index="z-50" />

@endsection