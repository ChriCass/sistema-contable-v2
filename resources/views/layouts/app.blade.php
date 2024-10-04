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
                                <img src="https://via.placeholder.com/100" alt="Logo Empresa"
                                    class="w-16 mb-2 h-16 rounded-full  text-center">
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
                            class="{{ request()->routeIs('empresa.dashboard') ? 'bg-teal-500 text-white' : 'text-gray-900 hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                            Panel principal
                        </a>
                        <a class="{{ request()->routeIs(['empresa.compra-venta', 'empresa.compra-venta.form']) ? 'bg-teal-500 text-white' : 'text-gray-900 hover:bg-teal-500 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium"
                            href="{{ route('empresa.compra-venta', ['id' => $empresa->id]) }}" wire:navigate>
                            Compra-Venta
                        </a>
                        
                        <a href="/registrarAsiento" wire:navigate
                            class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium hover:bg-teal-500 hover:text-white">Registrar
                            Asiento</a>
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = !dropdownOpen"
                                class="text-gray-900 w-full text-left px-3 py-2 rounded-md text-base font-medium flex items-center hover:bg-teal-500 hover:text-white">
                                Registros
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="dropdownOpen"
                                class="mt-2 space-y-1 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10"
                                x-cloak>
                                <a href="#" wire:navigate
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">R. Ventas</a>
                                <a href="#" wire:navigate
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">R. Compras</a>
                            </div>
                        </div>
                        <a href="/home" wire:navigate
                            class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium hover:bg-teal-500 hover:text-white">Caja-Diario</a>
                        <a href="/home" wire:navigate
                            class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium hover:bg-teal-500 hover:text-white">Hoja
                            de trabajo</a>
                        <a href="/home" wire:navigate
                            class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium hover:bg-teal-500 hover:text-white">Diario</a>
                        <a href="/home" wire:navigate
                            class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium hover:bg-teal-500 hover:text-white">Pendientes</a>
                        <a href="/home" wire:navigate
                            class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium hover:bg-teal-500 hover:text-white">Conrrentistas</a>
                        <a href="/home" wire:navigate
                            class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium hover:bg-teal-500 hover:text-white">Mayor</a>
                        <a href="/home" wire:navigate
                            class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium hover:bg-teal-500 hover:text-white">Plan
                            contable</a>
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
                                    <path :class="{ 'hidden': !sidebarOpen, 'inline-flex': sidebarOpen }" class="hidden"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
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
