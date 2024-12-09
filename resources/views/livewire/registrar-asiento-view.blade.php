<div>
    <x-card>
        <h1 class="font-bold">Registro de Asiento</h1>
    </x-card>
        <!-- Sección de Tabla con Scroll -->
        <x-card class="p-4 w-full overflow-x-auto my-3">

            <div x-data="{ openForm: false }">
                <button @click="openForm = !openForm"
                    :class="openForm ? 'bg-yellow-500 text-white' : 'bg-blue-500 text-white'"
                    class="px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <span x-text="openForm ? 'Ocultar formulario' : 'Mostrar formulario'"></span>
                </button>
                <div x-show="openForm" class="mt-5" x-transition>
                    @livewire('reusable-form')
                </div>
            </div>
    
            
        </x-card>
      
      
    <x-card class="p-4 w-full mt-5">
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <!-- Campo LIBRO -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">LIBRO:</span>
                    <x-select class="flex-1 w-full" :options="$libro" option-value="N" option-label="DESCRIPCION"
                        id="libro" wire:model="libro" placeholder="Seleccionar tipo de libro" />
                </div>

                <!-- Campo MES -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">MES:</span>
                    <x-select class="flex-1 w-full" :options="$mes" option-value="N" option-label="MES" id="mes"
                        wire:model="mes" placeholder="Meses" />
                </div>

                <!-- Campo FECHA -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">FECHA:</span>
                    <x-datetime-picker class="flex-1 w-full" without-time placeholder="Appointment Date" id="fecha_ven"
                        wire:model="fecha_vaucher" required />
                </div>

                <!-- Campo GLOSA GEN -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">GLOSA GEN:</span>
                    <x-input class="flex-1 w-full" oninput="this.value = this.value.toUpperCase()"></x-input>
                </div>

                <!-- Campo MONEDA -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">MONEDA:</span>
                    <x-select class="flex-1 w-full" :options="$moneda" option-value="COD" option-label="COD"
                        id="moneda" wire:model="moneda" placeholder="Moneda" />
                </div>
                <div class="w-full md:w-1/3 flex flex-col items-center px-4 my-10">
                    <button wire:click="procesarReporte"
                        class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-8 rounded-full shadow-lg transform hover:scale-105 transition-transform duration-300 ease-in-out flex items-center space-x-2 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                            <path
                                d="M20 8l-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM9 19H7v-9h2v9zm4 0h-2v-6h2v6zm4 0h-2v-3h2v3zM14 9h-1V4l5 5h-4z">
                            </path>
                        </svg>
                        <span>Procesar</span>
                    </button>
                </div>
            </div>

      
        </div>
    </x-card>

    <div  class="mt-5">
        <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-full">
       
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">CNTA</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DESCRIPCION</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DEBE S/</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">HABER S/</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DEBE $</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">HABER $</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">T.C</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">GLOSA ESPECIFICA</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">CORRENT</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">RAZ SOCIAL</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">TDOC</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">SER</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NUM</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">M. PAG</th>
 
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">CC</th>
 
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ESTADO DOC</th>
 
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ESTADO</th>
 
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ORDEN</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                   
                        <tr>
                            <td class="px-2 py-1 border-b text-center">Ejemplo Empresa</td>
                            <td class="px-2 py-1 border-b text-center">Ejemplo Libro</td>
                            <td class="px-2 py-1 border-b text-center">2024-12-08</td>
                            <td class="px-2 py-1 border-b text-center">2024-12-09</td>
                            <td class="px-2 py-1 border-b text-center">12345678</td>
                            <td class="px-2 py-1 border-b text-center">Juan Pérez</td>
                            <td class="px-2 py-1 border-b text-center">Factura</td>
                            <td class="px-2 py-1 border-b text-center">A001</td>
                            <td class="px-2 py-1 border-b text-center">000123</td>
 
                        </tr>
                    </tbody>
                    
                </table>
            </div>
        
        </div>
    </div>




</div>
