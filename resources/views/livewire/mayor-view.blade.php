<div x-data="{ showCard: @entangle('showCard'), animating: false }" x-init="$watch('showCard', value => { animating = value })">
    <x-card class="mb-3">
        <h1 class="font-bold">Mayor</h1>
    </x-card>
    <x-card class="p-4 mb-4">
        <div class="flex items-center space-x-4">
            <div class="flex items-center">
                <x-select wire:model="mes" :options="$meses" option-label="MES" option-value="N"
                    placeholder="Seleccione un mes" />
            </div>
            <div class="flex items-center space-x-2">
                <input type="radio" name="mes" value="x Mes" wire:model="tipoMes" checked>
                <label class="text-sm">x Mes</label>
                <input type="radio" name="mes" value="hasta Mes" wire:model="tipoMes">
                <label class="text-sm">hasta Mes</label>
            </div>
            <button class="bg-blue-600 text-white py-2 px-6 rounded shadow-lg" wire:click="procesarDiario">
                Procesar
            </button>

             
            @if (session()->has('success'))
            <div class="mt-4 p-4 bg-gray-100 rounded shadow">
                <h5 class="text-lg font-semibold mb-2">¿Prefieres empezar de cero?</h5>
                <x-button wire:click="deleteResult" icon="trash" label="Borrar registros generados" danger />
            </div>
        @endif
        </div>
    </x-card>

    <!-- Mostrar las alertas según el mensaje de la sesión -->
    @if (session()->has('success'))
        <x-alert title="Hecho!" positive padding="none" class="pl-1 mt-1 ml-3">
            <x-slot name="slot">
                {{ session('success') }}
            </x-slot>
        </x-alert>
    @endif

    @if (session()->has('error'))
        <x-alert title="Error!" negative padding="small" class="pl-1 mt-1 ml-3">
            <x-slot name="slot">
                {{ session('error') }}
            </x-slot>
        </x-alert>
    @endif

    @if (session()->has('alert'))
        <x-alert title="Cuidado" warning padding="none" class="pl-1 mt-1 ml-3">
            <x-slot name="slot">
                {{ session('alert') }}
            </x-slot>
        </x-alert>
    @endif

    <!-- Card adicional que se muestra al procesar -->
    <div x-show="animating" x-transition.duration.500ms class="mt-4">
        <x-card class="p-4">
            <h3 class="text-lg font-bold mb-4">¡Tenemos los registros listos! ¿Qué desea hacer?</h3>
            <div class="flex space-x-4">
                <button class="bg-green-600 text-white py-2 px-6 rounded shadow-lg" wire:click="exportarDiario">
                    Exportar Excel
                </button>
                <div x-data="{ showAlert: false }">
                    <!-- Botón Exportar PDF -->
                    <button 
                        class="bg-red-600 text-white py-2 px-6 rounded shadow-lg hover:bg-red-700 disabled:bg-gray-400 disabled:cursor-not-allowed disabled:opacity-50"
                        @mouseenter="showAlert = true"
                        @mouseleave="showAlert = false"
                        disabled>
                        Exportar PDF
                    </button>
                
                    <!-- Alerta -->
                    <div 
                        x-show="showAlert" 
                        x-transition.duration.300ms
                        class="fixed top-[30rem] left-[50rem] bg-yellow-300 text-yellow-900 p-3 rounded shadow-lg text-sm"
                        style="display: none;">
                        La exportación a PDF aún no está disponible. ¡Espera noticias de esta función pronto!
                    </div>
                </div>
                
            
            </div>
        </x-card>

        <!-- Alerta informativa -->
        <x-alert title="Información importante" info padding="small" class="mt-4">
            <x-slot name="slot">
                Debido al volumen de datos, hemos generado los archivos por separado para garantizar un desempeño
                óptimo. Si tienes alguna consulta, no dudes en contactar al soporte.
            </x-slot>
        </x-alert>
    </div>
</div>
