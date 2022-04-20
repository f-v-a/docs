@extends('layouts.main_layout')

@section('title', 'Регламентные задачи')
@section('page-title', 'Регламентные задачи')

@section('content')

@livewire('tables.regulatory-task-table')
<x-notifications z-index="z-50" />
{{-- @foreach ($dat as $da)
    <p>{{ $da . "\n" }} </p>

@endforeach --}}

@endsection