@extends('layouts.main_layout')

@section('title', 'Работники')
@section('page-title', 'Работники')

@section('content')


    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
            <li  role="presentation">
                <a href="{{ route('contractors.index') }}" class="inline-flex py-4 px-4 text-sm font-medium text-center text-gray-500 
                rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 
                dark:text-gray-400 dark:hover:text-gray-300 group" id="contragent-tab" data-tabs-target="#contragent" role="tab" aria-controls="contragent" aria-selected="false">
                    <svg class="mr-2 w-5 h-5 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path></svg>Контрагенты
                </a>
            </li>
            <li role="presentation">
                <a href="#" class="inline-flex py-4 px-4 text-sm font-medium text-center text-gray-500 
                rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 
                dark:text-gray-400 dark:hover:text-gray-300 group active" id="performers-tab" data-tabs-target="#performers" type="button" role="tab" aria-controls="performers" aria-selected="true">
                    <svg class="mr-2 w-5 h-5 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path></svg>Мастера
                </a>
            </li>
        </ul>
    </div>
    <div id="myTabContent">
        <div class="hidden p-4 rounded-lg dark:bg-gray-800" id="contragent" role="tabpanel" aria-labelledby="contragent-tab">
        </div>

        <div class="p-4 rounded-lg dark:bg-gray-800" id="performers" role="tabpanel" aria-labelledby="performers-tab">
            <div class = "table-responsive">
                <div class="card has-table">
                    @livewire('tables.performers-table')
                <x-notifications z-index="z-50" />
                </div>
            </div>
        </div>
    </div>


@endsection