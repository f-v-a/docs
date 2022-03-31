@extends('layouts.main_layout')

@section('title', 'Пользователи')
@section('page-title', 'Пользователи')

@section('content')

    @livewire('tables.user-table')
    <x-notifications z-index="z-50" />

@endsection