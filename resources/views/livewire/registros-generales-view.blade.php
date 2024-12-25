<div>
    <x-card>
        <h2 class="text-lg font-bold">
            @php
                // 1. Obtener el nombre de la ruta actual, por ejemplo "empresa.registros-generales"
                $routeName = Route::currentRouteName();
    
                // 2. Reemplazar los guiones y guiones bajos por espacios
                //    de modo que "registros-generales" -> "registros generales"
                $routeName = str_replace(['-', '_'], ' ', $routeName);
    
                // 3. (Opcional) si quieres quitar el prefijo "empresa."
                //    para quedarte sólo con "registros generales"
                $routeName = str_replace('empresa.', '', $routeName);
    
                // 4. Obtener el valor de 'origen' que pasaste en la ruta
                $origen = request()->get('origen');
            @endphp
    
            <!-- 5. Mostrar el resultado "Registros generales de compras" (por ejemplo) -->
            {{ ucfirst($routeName) }} de {{ $origen }}
        </h2>
    </x-card>
    

    <x-card class="p-4 w-full mt-5">
        @if (session()->has('error'))
            <x-alert title="Error!" negative class="mb-3">
                {{ session('error') }}
            </x-alert>
        @endif
        @if (session()->has('message'))
            <x-alert title="¡Transacción Exitosa!" class="mb-3" positive>
                {{ session('message') }}
            </x-alert>
        @endif

        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <!-- Campo LIBRO -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">LIBRO:</span>
                    <x-select class="flex-1 w-full" :options="$libro" option-value="id" option-label="DESCRIPCION"
                        id="libro" wire:model="lib" placeholder="Seleccionar tipo de libro" />
                </div>

                <!-- Campo MES -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">MES:</span>
                    <x-select class="flex-1 w-full" :options="$mes" option-value="N" option-label="MES" id="mes"
                        wire:model="mss" placeholder="Meses" />
                </div>
                <div class="my-4 flex justify-center">
                    <x-button teal label="Procesar" wire:click="Procesar" />
                </div>
            </div>
        </div>
    </x-card>

    <!-- Tabla de Resultados -->
    <div class="mt-5">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">aqui</th>
                            <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">los headers
                            </th>
                            <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">-</th>
                            <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">-</th>
                            <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">-</th>
                            <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">-</th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-2 py-1 border-b text-center">Feliz</td>
                            <td class="px-2 py-1 border-b text-center">Navidad</td>
                            <td class="px-2 py-1 border-b text-center">Para</td>
                            <td class="px-2 py-1 border-b text-center">todos</td>
                            <td class="px-2 py-1 border-b text-center">Feliz</td>
                            <td class="px-2 py-1 border-b text-center">Navidad</td>
                        </tr>
                    </tbody>


                </table>
            </div>
        </div>
    </div>
</div>
