<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @wireUiScripts
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false, userDropdownOpen: false }" class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div :class="{
            'translate-x-0 ease-out': sidebarOpen || !sidebarOpen && screen.width >= 640,
            '-translate-x-full ease-in': !
                sidebarOpen && screen.width < 640
        }"
            class="fixed inset-y-0 left-0 bg-white border-r border-gray-100 w-full h-full transform transition-transform duration-300 z-40 sm:w-64 sm:transform-none sm:static sm:inset-auto sm:h-auto sm:block">
            <div class="h-full flex flex-col justify-between">
                <div class="flex-1 flex flex-col">
                    <!-- Close Button for Mobile -->
                    <div class="flex justify-end p-4 sm:hidden">
                        <button @click="sidebarOpen = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Logo -->
                    <div class="shrink-0 flex items-center justify-center h-16 bg-gray-200">
                        <a href="{{ route('empresa.dashboard', ['id' => $empresaId ?? 1]) }}" wire:navigate>
                            <x-application-mark class="block h-9 w-auto" />
                        </a>
                    </div>
                    <!-- Empresa Card -->
                    <div class="p-4 bg-white shadow-lg rounded-lg mt-4 mx-4">
                        <div class="flex items-center flex-col justify-center">
                            <div class="flex justify-center">
                                <div class="relative w-16 h-16 mb-2">
                                    <img src="{{ asset('img/default.webp') }}" alt="Logo Empresa" class="w-full h-full rounded-full object-cover">
                                    <div class="absolute inset-0 bg-black opacity-30 rounded-full"></div> <!-- Fondo oscuro -->
                                </div>
                                
                            </div>

                            <div>
                                <h2 class="text-md font-semibold text-gray-900 text-center">{{ $empresa->Nombre }}</h2>
                                <p class="text-sm text-gray-600 text-center">RUC: {{ $empresa->Ruc }}</p>
                                <p class="text-sm text-gray-600 text-center"> {{ $empresa->Anno }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Navigation Menu -->
                    <!-- Navigation Menu -->
                    <nav class="flex-1 px-2 py-4 space-y-1 bg-white">
                        <a href="{{ route('empresa.dashboard', ['id' => $empresa->id]) }}" wire:navigate
                            class="{{ request()->routeIs('empresa.dashboard') ? 'border-b-2 border-teal-500 text-teal-500' : 'text-gray-900 hover:border-b-2 hover:border-teal-500 hover:text-teal-500' }} block px-3 py-2 rounded-md text-base font-medium">
                            Panel principal
                        </a>


                        <div x-data="{
                            dropdownOpen: {{ request()->routeIs('empresa.compra-venta') || request()->routeIs('empresa.lista-asiento') || request()->routeIs('empresa.registrar-asiento') || request()->routeIs('empresa.compra-venta.form') ? 'true' : 'false' }},
                            isActive: false
                        }" class="relative">

                            <button @click="dropdownOpen = !dropdownOpen; isActive = dropdownOpen"
                                :class="{ 'border-b-2 border-teal-500 text-teal-500': dropdownOpen }"
                                class="text-gray-900 w-full text-left px-3 py-2 rounded-md text-base font-medium flex items-center hover:border-b-2 hover:border-teal-500 hover:text-teal-500">
                                Registros
                                <svg :class="{ 'transform rotate-180 text-teal-500': dropdownOpen }"
                                    class="ml-1 w-4 h-4 transition-transform duration-300 ease-in-out" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>


                            <div x-show="dropdownOpen" x-transition:enter="transition-opacity duration-300 ease-out"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="transition-opacity duration-300 ease-in"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                class="mt-2 space-y-1 bg-white rounded-lg ring-1 ring-black ring-opacity-5 z-10 overflow-hidden"
                                x-cloak>
                                <a href="#" wire:navigate
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-100 hover:text-teal-900 rounded-md transition duration-150 ease-in-out">
                                    R. Ventas
                                </a>
                                <a href="#" wire:navigate
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-teal-100 hover:text-teal-900 rounded-md transition duration-150 ease-in-out">
                                    R. Compras
                                </a>
                                <!-- Para mantener la ruta activa y el fondo del padre, usar request()->routeIs() -->
                                <a href="{{ route('empresa.compra-venta', ['id' => $empresa->id]) }}" wire:navigate
                                    class="{{ request()->routeIs('empresa.compra-venta') ? 'bg-teal-500 text-white font-medium' : ' hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md text-gray-700 text-sm">
                                    Compra-Venta
                                </a>

                                <a href="{{ route('empresa.registrar-asiento', ['id' => $empresa->id, 'origen' => 'registrar_asiento']) }}"
                                    wire:navigate
                                    class="{{ request()->routeIs('empresa.registrar-asiento') ? 'bg-teal-500 text-white font-medium' : ' hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md  text-gray-700 text-sm">
                                    Registrar Asiento
                                </a>
                                <a href="{{ route('empresa.lista-asiento', ['id' => $empresa->id]) }}"
                                    wire:navigate
                                    class="{{ request()->routeIs('empresa.lista-asiento') ? 'bg-teal-500 text-white font-medium' : ' hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md  text-gray-700 text-sm">
                                    Lista de asientos
                                </a>
                            </div>
                        </div>



                        <div x-data="{
                            dropdownOpen: {{   request()->routeIs('empresa.hoja-trabajo') || request()->routeIs('empresa.diario') || request()->routeIs('empresa.correntista') || request()->routeIs('empresa.plan-contable') ? 'true' : 'false' }},
                            isDropdownActive: false
                        }" class="relative">

                            <button @click="dropdownOpen = !dropdownOpen; isDropdownActive = dropdownOpen"
                                :class="{ 'border-b-2 border-teal-500 text-teal-500': dropdownOpen }"
                                class="text-gray-900 w-full text-left px-3 py-2 rounded-md text-base font-medium flex items-center hover:border-b-2 hover:border-teal-500 hover:text-teal-500">
                                Reportes
                                <svg :class="{ 'transform rotate-180 text-teal-500': dropdownOpen }"
                                    class="ml-1 w-4 h-4 transition-transform duration-300 ease-in-out" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>


                            <div x-show="dropdownOpen" x-transition:enter="transition-opacity duration-300 ease-out"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="transition-opacity duration-300 ease-in"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                class="mt-2 space-y-1 bg-white rounded-lg ring-1 ring-black ring-opacity-5 z-10 overflow-hidden"
                                x-cloak>

                         
                                <!-- Hoja de Trabajo Link -->
                                <a href="{{ route('empresa.hoja-trabajo', ['id' => $empresa->id]) }}" wire:navigate
                                    class="{{ request()->routeIs('empresa.hoja-trabajo') ? 'bg-teal-500 text-white font-medium' : ' hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md  text-gray-700 text-sm">
                                    Hoja de trabajo
                                </a>

                                <!-- Diario Link -->
                                <a href="{{ route('empresa.diario', ['id' => $empresa->id]) }}" wire:navigate
                                    class="{{ request()->routeIs('empresa.diario') ? 'bg-teal-500 text-white font-medium' : ' hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md  text-gray-700 text-sm">
                                    Diario
                                </a>

                                <!-- Pendientes Link -->
                                <a href="/home" wire:navigate
                                    class="{{ request()->routeIs('empresa.pendientes') ? 'bg-teal-500 text-white font-medium' : ' hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md  text-gray-700 text-sm">
                                    Pendientes
                                </a>

                                <!-- Correntistas Link -->
                                <a href="{{ route('empresa.correntista', ['id' => $empresa->id]) }}" wire:navigate
                                    class="{{ request()->routeIs('empresa.correntista') ? 'bg-teal-500 text-white font-medium' : ' hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md  text-gray-700 text-sm">
                                    Correntistas
                                </a>

                                <!-- Mayor Link -->
                                <a href="/home" wire:navigate
                                    class="{{ request()->routeIs('empresa.mayor') ? 'bg-teal-500 text-white font-medium' : ' hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md  text-gray-700 text-sm">
                                    Mayor
                                </a>

                                <!-- Plan Contable Link -->
                                <a href="{{ route('empresa.plan-contable', ['id' => $empresa->id]) }}" wire:navigate
                                    class="{{ request()->routeIs('empresa.plan-contable') ? 'bg-teal-500 text-white font-medium' : ' hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md  text-gray-700 text-sm">
                                    Plan contable
                                </a>

                            </div>
                        </div>

                    </nav>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <nav class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Hamburger -->
                            <button @click="sidebarOpen = !sidebarOpen"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out sm:hidden">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{ 'hidden': sidebarOpen, 'inline-flex': !sidebarOpen }"
                                        class="inline-flex" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{ 'hidden': !sidebarOpen, 'inline-flex': sidebarOpen }"
                                        class="hidden" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Right side -->
                        <div class="flex items-center space-x-4">
                            <!-- Cambiar Empresa Button -->
                            <x-button href="{{ route('dashboard') }}" wire:navigate info>
                                Cambiar Empresa
                            </x-button>

                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <button @click="userDropdownOpen = !userDropdownOpen"
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}"
                                        alt="{{ Auth::user()->name }}" />
                                </button>
                                <div x-show="userDropdownOpen" @click.away="userDropdownOpen = false"
                                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-20"
                                    x-cloak>
                                    <a href="{{ route('profile.show') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Profile') }}
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 responsive-main">
                {{ $slot }}
            </main>


        </div>
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>
