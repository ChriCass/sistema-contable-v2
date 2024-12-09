<div>
    <x-card>
        <h1 class="font-bold">hoja de trabajo</h1>
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
        <div class="flex flex-wrap justify-center gap-2">

            <div class="w-full md:w-5/12">

                <div class="text-sm font-bold flex items-center">

                    <x-select label="mes" class="flex-1 w-full" :options="$mes" option-value="N" option-label="MES"
                        id="mes" wire:model="mes" placeholder="Meses" />
                </div>
            </div>




            <div class="w-full flex flex-col items-center mt-4 ">
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
    </x-card>

    <div class="mt-5">
        <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-full">
            <div class="p-5 flex flex-wrap justify-center">
                <div class="w-2/12">
                    <h3 class="font-semibold text-center">Sumas</h3>
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Debe</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Haber</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-2 py-1 border-b text-center">12345678</td>
                                <td class="px-2 py-1 border-b text-center">98765432</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
    
                <div class="w-2/12">
                    <h3 class="font-semibold text-center">Mayor</h3>
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Debe</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Haber</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-2 py-1 border-b text-center">1232131238</td>
                                <td class="px-2 py-1 border-b text-center">12312312</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
    
                <div class="w-2/12">
                    <h3 class="font-semibold text-center">Ajustes</h3>
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Debe</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Haber</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-2 py-1 border-b text-center">1312312</td>
                                <td class="px-2 py-1 border-b text-center">12312321321</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
    
                <div class="w-2/12">
                    <h3 class="font-semibold text-center">Situación Financiera</h3>
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Debe</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Haber</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-2 py-1 border-b text-center">1231231231</td>
                                <td class="px-2 py-1 border-b text-center">12312312</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
    
                <div class="w-2/12">
                    <h3 class="font-semibold text-center">Resultados x Naturaleza</h3>
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Debe</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Haber</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-2 py-1 border-b text-center">12345678</td>
                                <td class="px-2 py-1 border-b text-center">98765432</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
    
                <div class="w-2/12">
                    <h3 class="font-semibold text-center">Resultados x Función</h3>
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Debe</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Haber</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-2 py-1 border-b text-center">12345678</td>
                                <td class="px-2 py-1 border-b text-center">98765432</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

</div>
