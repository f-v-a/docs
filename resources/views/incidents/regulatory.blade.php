@extends('layouts.main_layout')

@section('title', 'Регламентные задачи')
@section('page-title', 'Регламентные задачи')

@section('content')

    {{--@livewire('tables.regulatory-task-table')--}}
    <x-notifications z-index="z-50"/>
    {{-- @foreach ($dat as $da)
        <p>{{ $da . "\n" }} </p>

    @endforeach --}}
    {{--    @livewire('tasks-filter')--}}
    <div class="w-full flex justify-end">
        <div @click.away="openSort = false" class="w-full relative" x-data="{ openSort: false,sortType:'Sort by' }">
            <button class="w-full flex justify-end py-2 mt-2 cursor-auto">
                <svg @click="openSort = !openSort" xmlns="http://www.w3.org/2000/svg" class="cursor-pointer h-6 w-6"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
            </button>
            <div x-show="openSort" x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute z-50 w-full flex justify-end origin-top-right">
                <div class="px-2 pt-2 pb-2 bg-white rounded-md shadow-lg dark-mode:bg-gray-700">
                    <div class="flex flex-col">
                        <a @click="sortType='Most disscussed',openSort=!openSort" x-show="sortType != 'Most disscussed'"
                           class="flex flex-row items-start rounded-lg bg-transparent p-2 hover:bg-gray-200 "
                           href="{{ route('regulatory-tasks.index', ['sort' => 'asc']) }}">
                            <div class="">
                                <p class="text-sm">По возрастанию</p>
                            </div>
                        </a>

                        <a @click="sortType='Most popular',openSort=!openSort" x-show="sortType != 'Most popular'"
                           class="flex flex-row items-start rounded-lg bg-transparent p-2 hover:bg-gray-200 "
                           href="{{ route('regulatory-tasks.index', ['sort' => 'desc']) }}">
                            <div class="">
                                <p class="text-sm">По убыванию</p>
                            </div>
                        </a>

                        <a @click="sortType='Most upvoted',openSort=!openSort" x-show="sortType != 'Most upvoted'"
                           class="flex flex-row items-start rounded-lg bg-transparent p-2 hover:bg-gray-200 "
                           href="{{ route('regulatory-tasks.index', ['date' => 'date']) }}">
                            <div class="">
                                <p class="text-sm">По ближайшей дате</p>
                            </div>
                        </a>

                        <a @click="sortType='Most upvoted',openSort=!openSort" x-show="sortType != 'Most upvoted'"
                           class="flex flex-row items-start rounded-lg bg-transparent p-2 hover:bg-gray-200 "
                           href="{{ route('regulatory-tasks.index', ['status' => '2']) }}">
                            <div class="">
                                <p class="text-sm">Активные</p>
                            </div>
                        </a>

                        <a @click="sortType='Most upvoted',openSort=!openSort" x-show="sortType != 'Most upvoted'"
                           class="flex flex-row items-start rounded-lg bg-transparent p-2 hover:bg-gray-200 "
                           href="{{ route('regulatory-tasks.index', ['status' => '1']) }}">
                            <div class="">
                                <p class="text-sm">Приостановленные</p>
                            </div>
                        </a>

                        <a @click="sortType='Most upvoted',openSort=!openSort" x-show="sortType != 'Most upvoted'"
                           class="flex flex-row items-start rounded-lg bg-transparent p-2 hover:bg-gray-200 "
                           href="{{ route('regulatory-tasks.index', ['status' => '3']) }}">
                            <div class="">
                                <p class="text-sm">Завершенные</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 pt-6 gap-8">
        @forelse($regulatories as $regulatory)
            <div class="rounded w-full" x-data="{open: false}">
                <div class="block rounded-lg shadow-lg bg-white max-w-lg text-center">
                    <div class="py-3 pt-6 border-b border-gray-300 text-xl font-medium">
                        <div class="flex flex-row justify-between px-6">
                            Задача #{{ $regulatory->id }}
                            <div class="flex flex-row">
                                <span class="sm:mt-0 focus:outline-none px-5 py-2 rounded text-sm leading-none
                                @if($regulatory->status === 1) bg-red-100 text-red-700
                                    @elseif($regulatory->status === 2) bg-indigo-100 text-indigo-700
                                        @else bg-green-100 text-green-700
                                @endif">
                                @if($regulatory->status === 1) Приостановлена
                                    @elseif($regulatory->status === 2) Выполняется
                                    @else Завершена
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col justify-between md:flex-row items-start md:items-center p-6">
                            <div tabindex="0"
                                 class="text-xs text-center w-full bg-indigo-100 text-indigo-700 dark:text-indigo-600 rounded font-medium p-3 lg:mr-3">
                                Начало: <br>
                                {{ $regulatory->start_date->isoFormat('Do MMMM YYYY') }}
                            </div>
                            <div tabindex="0"
                                 class="mt-4 text-center w-full lg:mt-0 text-xs bg-red-100 text-red-700 rounded font-medium p-3">
                                Завершение: <br>
                                {{ $regulatory->end_date ? $regulatory->end_date->isoFormat('Do MMMM YYYY') : 'Бессрочно' }}
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col p-6 text-sm">
                        <h2 class="text-left leading-3 dark:text-gray-400 text-gray-600 dark:text-gray-500">
                            Оборудование: {{ $regulatory->equipment->name }}</h2>
                        <h2 class="text-left leading-3 dark:text-gray-400 text-gray-600 dark:text-gray-500 my-4">
                            Серийный номер: {{ $regulatory->equipment->serial_number }}</h2>
                        <h2 class="text-left leading-3 dark:text-gray-400 text-gray-600 dark:text-gray-500">
                            Периодичность:
                            {{ \App\Http\Controllers\RegulatoryTaskController::changeDaysToMonth($regulatory->periodicity) }}
                        </h2>
                        <h2 class="text-left leading-3 dark:text-gray-400 text-gray-600 dark:text-gray-500 my-4">
                            Ближайшие проверки:
                        </h2>
                        <div class="flex flex-col justify-between items-stretch xl:flex-row">
                            @if($regulatory->mode == 1 && $regulatory->status == 2)
                                @if(\App\Http\Controllers\RegulatoryTaskController::findToday($regulatory->start_date, $regulatory->end_date, $regulatory->periodicity))
                                    <span
                                        class="sm:mt-0 flex items-center justify-center focus:outline-none px-5 py-2 2xl:rounded text-sm leading-none bg-green-100 text-green-700 align-self-center">
                                    Сегодня
                                </span>
                                @endif
                                <span
                                    class="sm:mt-0 focus:outline-none px-5 py-2 2xl:rounded text-sm leading-none bg-indigo-100 text-indigo-700 dark:text-indigo-600">
                                {{ \App\Http\Controllers\RegulatoryTaskController::findNextDay($regulatory->start_date, $regulatory->end_date, $regulatory->periodicity, true) }}
                                г
                                    </span>
                                <span
                                    class="sm:mt-0 focus:outline-none px-5 py-2 2xl:rounded text-sm leading-none bg-indigo-100 text-indigo-700 dark:text-indigo-600">
                                {{ \App\Http\Controllers\RegulatoryTaskController::findNextDay($regulatory->start_date, $regulatory->end_date, $regulatory->periodicity) }}
                                г
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="p-6 pt-0 w-full">
                        <h5 class="text-gray-900 text-md font-medium mb-2">Описание</h5>
                        <p class="text-gray-700 text-sm mb-4 text-justify break-words">
                            @if(strlen($regulatory->modify_description) > 235)
                                {{ $regulatory->modify_description }}...
                            @else
                                {{ $regulatory->modify_description }}
                            @endif
                        </p>
                    </div>
                    <div class="pt-4 pb-4 px-6 border-t border-gray-300 text-gray-600">
                        @if($regulatory->status < 3)
                            <div class="flex justify-end">
                                <div class="relative inline-block">
                                    @livewire('dropdown-menu', ['taskId' => $regulatory->id])
                                    <x-notifications z-index="z-50"/>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <span class="text-lg">
                Регламентных задач не найдено
            </span>
        @endforelse
    </div>
@endsection
