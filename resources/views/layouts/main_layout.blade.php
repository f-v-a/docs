<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('picture/icon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/6.5.95/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <link rel="stylesheet" href="{{ asset('dist/app.css') }}">
    {{-- <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.1/dist/flowbite.min.css" /> --}}
    @livewireStyles
    @powerGridStyles
    @wireUiScripts
    <style> .dataTables_wrapper select {background-image: unset;} 
    </style>
    <title>@yield('title')</title>
</head>

<body class="antialiased bg-gray-100">
    @auth
    <div class="flex relative" x-data="{navOpen: false}">
        <!-- NAV -->
        <nav class="absolute z-10 md:relative w-64 transform -translate-x-full md:translate-x-0 h-screen overflow-y-scroll bg-black transition-all duration-300" :class="{'-translate-x-full': !navOpen}">
            <div class="flex flex-col justify-between h-full">
                <div class="p-4">
                    <!-- LOGO -->
                    <a class="flex items-center text-white space-x-4" href="">
                        {{-- <svg class="w-7 h-7 bg-indigo-600 rounded-lg p-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg> --}}
                        <span class="text-2xl font-bold">MedExpert</span>
                    </a>

                    <!-- NAV LINKS -->
                    <div class="py-4 text-gray-400 space-y-1">
                        <!-- DROPDOWN LINK -->
                        @if (auth()->user()->is_admin || auth()->user()->is_user)
                        <div class="block" x-data="{open: false, openRegular: false}">
                            <div @click="open = !open" class="flex items-center justify-between hover:bg-gray-800 hover:text-white cursor-pointer py-2.5 px-4 rounded">
                                <div class="flex items-center space-x-2">
                                    <span class="icon"><i class="mdi mdi-note-plus mdi-24px"></i></span>
                                    <span>Создать</span>
                                </div>
                                <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>    
                            </div>
                            <div x-show="open" class="text-sm border-l-2 border-gray-800 mx-6 my-2.5 px-2.5 flex flex-col gap-y-1">
                                <a href="#" onclick="Livewire.emit('openModal', 'incidents.store')" 
                                class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    Инцидент
                                </a>
                                @if (auth()->user()->is_admin)
                                    <a href="#" onclick="Livewire.emit('openModal', 'equipments.store')"
                                    class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                        Оборудование
                                    </a>
                                    <a href="#" onclick="Livewire.emit('openModal', 'employees.store')"
                                    class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                        Сотрудник
                                    </a>
                                    <a href="#" onclick="Livewire.emit('openModal', 'contractors.store')"
                                    class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                        Контрагент
                                    </a>
                                @endif
                                @if (auth()->user()->is_admin || auth()->user()->is_chief)
                                    <div @click="openRegular = !openRegular" class="flex items-center justify-between hover:bg-gray-800 hover:text-white cursor-pointer py-2.5 px-4 rounded">
                                        <span>Регламентная задача</span>
                                    </div>
                                    
                                    <div x-show="openRegular" class="text-sm border-l-2 border-gray-800 ml-6 my-2.5 px-2 flex flex-col gap-y-1">
                                        <a href="#" onclick="Livewire.emit('openModal', 'regulatory-tasks-daily.store')"
                                        class="block py-2 px-2 hover:bg-gray-800 hover:text-white rounded">
                                            По дням
                                        </a>
                                        <a href="#" onclick="Livewire.emit('openModal', 'regulatory-tasks-weekly.store')"
                                        class="block py-2 px-2 hover:bg-gray-800 hover:text-white rounded">
                                            По неделям
                                        </a>
                                        <a href="#" onclick="Livewire.emit('openModal', 'regulatory-tasks-monthly.store')"
                                        class="block py-2 px-2 hover:bg-gray-800 hover:text-white rounded">
                                            По месяцам
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="block" x-data="{open: false}">
                            <div @click="open = !open" class="flex items-center justify-between hover:bg-gray-800 hover:text-white cursor-pointer py-2.5 px-4 rounded">
                                <div class="flex items-center space-x-2">
                                    <span class="icon"><i class="mdi mdi-inbox-full mdi-24px"></i></span>
                                    <span>Инциденты</span>
                                </div>
                                <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>    
                            </div>
                            <div x-show="open" class="text-sm border-l-2 border-gray-800 mx-6 my-2.5 px-2.5 flex flex-col gap-y-1">
                                <a href="{{ route('incidents.index') }}" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    Входящие
                                </a>
                                <a href="{{ route('completed-incidents.index') }}" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                    Завершенные
                                </a>
                            </div>
                        </div>
                        @if (auth()->user()->is_admin || auth()->user()->is_chief)
                            <div class="block" x-data="{open: false}">
                                <div @click="open = !open" class="flex items-center justify-between hover:bg-gray-800 hover:text-white cursor-pointer py-2.5 px-4 rounded">
                                    <div class="flex items-center space-x-2">
                                        <span class="icon"><i class="mdi mdi-cogs mdi-24px"></i></span>
                                        <span>Оборудование</span>
                                    </div>
                                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>    
                                </div>
                                <div x-show="open" class="text-sm border-l-2 border-gray-800 mx-6 my-2.5 px-2.5 flex flex-col gap-y-1">
                                    <a href="{{ route('active.index') }}" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                        Активное
                                    </a>
                                    <a href="{{ route('decommissioned.index') }}" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                        Выведенное из эксплуатации
                                    </a>
                                    <a href="{{ route('written-off.index') }}" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                        Списанное
                                    </a>
                                </div>
                            </div>
                            <div class="block" x-data="{open: false}">
                                <div @click="open = !open" class="flex items-center justify-between hover:bg-gray-800 hover:text-white cursor-pointer py-2.5 px-4 rounded">
                                    <div class="flex items-center space-x-2">
                                        <span class="icon"><i class="mdi mdi-account-multiple mdi-24px"></i></span>
                                        <span>Персонал</span>
                                    </div>
                                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>    
                                </div>
                                <div x-show="open" class="text-sm border-l-2 border-gray-800 mx-6 my-2.5 px-2.5 flex flex-col gap-y-1">
                                    <a href="{{ route('employees.index') }}" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                        Сотрудники
                                    </a>
                                    <a href="{{ route('contractors.index') }}" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                        Контрагенты
                                    </a>
                                </div>
                            </div>
                            <div class="block" x-data="{open: false}">
                                <div @click="open = !open" class="flex items-center justify-between hover:bg-gray-800 hover:text-white cursor-pointer py-2.5 px-4 rounded">
                                    <div class="flex items-center space-x-2">
                                        <span class="icon"><i class="mdi mdi-book-multiple mdi-24px"></i></span>
                                        <span>Справочники</span>
                                    </div>
                                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>    
                                </div>
                                <div x-show="open" class="text-sm border-l-2 border-gray-800 mx-6 my-2.5 px-2.5 flex flex-col gap-y-1">
                                    <a href="{{ route('types.index') }}" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                        Типы
                                    </a>
                                    <a href="{{ route('models.index') }}" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                        Модели
                                    </a>
                                    <a href="{{ route('positions.index') }}" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                        Должности
                                    </a>
                                    <a href="{{ route('users') }}" class="block py-2 px-4 hover:bg-gray-800 hover:text-white rounded">
                                        Данные пользователя
                                    </a>
                                </div>
                            </div>
                        @endif

                        {{-- <!-- BASIC LINK -->
                        <a href="#" class="block py-2.5 px-4 flex items-center space-x-2 bg-gray-800 text-white hover:bg-gray-800 hover:text-white rounded">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Dashboard</span>
                        </a> --}}
                    </div>
                </div>

                <!-- PROFILE -->
                <div class="text-gray-200 border-gray-800 rounded flex items-center justify-between p-2">
                    <div class="flex items-center space-x-2">
                        <!-- AVATAR IMAGE BY FIRST LETTER OF NAME -->
                        <img src="https://ui-avatars.com/api/?name=Habib+Mhamadi&size=128&background=ff4433&color=fff" class="w-7 w-7 rounded-full" alt="Profile">
                        <h1>    
                            {{ auth()->user()->name ?? '' }} 
                            {{ auth()->user()->patronymic ?? '' }} 
                        </h1>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="hover:bg-gray-800 hover:text-white p-2 rounded">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>            
                        </button>
                    </form>
                </div>

            </div>
        </nav>
        <!-- END OF NAV -->

        <!-- PAGE CONTENT -->
        <main class="flex-1 h-screen overflow-y-scroll overflow-x-hidden">
            <div class="md:hidden justify-between items-center bg-black text-white flex">
                <h1 class="text-2xl font-bold px-4">MedExpert</h1>
                <button @click="navOpen = !navOpen" class="btn p-4 focus:outline-none hover:bg-gray-800">
                    <svg class="w-6 h-6 fill-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
            <section class="max-w-9xl mx-auto py-4 px-5">
                <div class="flex flex-col justify-between md:flex-row items-center border-b border-gray-300">
                    <h1 class="text-2xl font-semibold">@yield('page-title')</h1>
                    <nav class="flex pt-3 pb-2" aria-label="Breadcrumb">
                        <span class="inline-flex items-center">
                            <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                <span class="icon"><i class="mdi mdi-arrow-left-bold mdi-36px"></i></span>
                            </a>
                        </span>
                    </nav>
                </div>

                <!-- TABLE -->
                <div class="bg-white my-10">
                    <div class="px-4 py-4">
                        @yield('content')

                    </div>
                </div>
                <!-- END OF TABLE -->

            </section>
            <!-- END OF PAGE CONTENT -->
        </main>
    </div>
    @endauth
{{-- <script src="{{ asset('dist/main.min.js') }}"></script> --}}



<script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
@livewireScripts
@powerGridScripts
@livewire('livewire-ui-modal')
</body>
</html>