<div x-data="{ sidebarOpen: false, userDropdownOpen: false }" class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div :class="{'translate-x-0 ease-out': sidebarOpen || !sidebarOpen && screen.width >= 640, '-translate-x-full ease-in': !sidebarOpen && screen.width < 640}" 
         class="fixed inset-y-0 left-0 bg-white border-r border-gray-100 w-full h-full transform transition-transform duration-300 z-40 sm:w-64 sm:transform-none sm:static sm:inset-auto sm:h-auto sm:block">
        <div class="h-full flex flex-col justify-between">
            <div class="flex-1 flex flex-col">
                <!-- Close Button for Mobile -->
                <div class="flex justify-end p-4 sm:hidden">
                    <button @click="sidebarOpen = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Logo -->
                <div class="shrink-0 flex items-center justify-center h-16 bg-gray-200">
                    <a href="/" wire:navigate>
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 px-2 py-4 space-y-1 bg-white">
                    <a href="/empresa/show" wire:navigate class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Panel principal</a>
                    <a href="/compraVenta" wire:navigate class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Compra-Venta</a>
                    <a href="/registrarAsiento" wire:navigate class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Registrar Asiento</a>
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" class="text-gray-900 w-full text-left px-3 py-2 rounded-md text-base font-medium flex items-center">
                            Registros
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="dropdownOpen" class="mt-2 space-y-1 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10" x-cloak>
                            <a href="#" wire:navigate class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">R. Ventas</a>
                            <a href="#" wire:navigate class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">R. Compras</a>
                        </div>
                    </div>
                    <a href="/home" wire:navigate class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Caja-Diario</a>
                    <a href="/home" wire:navigate class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Hoja de trabajo</a>
                    <a href="/home" wire:navigate class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Diario</a>
                    <a href="/home" wire:navigate class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Pendientes</a>
                    <a href="/home" wire:navigate class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Conrrentistas</a>
                    <a href="/home" wire:navigate class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Mayor</a>
                    <a href="/home" wire:navigate class="text-gray-900 block px-3 py-2 rounded-md text-base font-medium">Plan contable</a>
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
                        <button @click="sidebarOpen = !sidebarOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out sm:hidden">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': sidebarOpen, 'inline-flex': !sidebarOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !sidebarOpen, 'inline-flex': sidebarOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Right side -->
                    <div class="flex items-center">
                        <!-- Settings Dropdown -->
                        <div class="ms-3 relative">
                            <button @click="userDropdownOpen = !userDropdownOpen" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </button>
                            <div x-show="userDropdownOpen" @click.away="userDropdownOpen = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-20" x-cloak>
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    {{ __('Profile') }}
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" @click.prevent="$root.submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Log Out') }}
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto">
      
          <x-welcome/>
        </main>
    </div>
</div>
