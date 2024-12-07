<div>
    <x-modal name="persistentModal" wire:model="openModal">
        <x-card title="Centro de Costos">
            <!-- Contenido del cuadro (modal) -->
            <div class="p-1">
                
                @if (session()->has('error'))
                    <x-alert title="Error!" negative class="mb-3">
                        {{ session('error') }}
                    </x-alert>
                @endif
        
                <!-- Contenedor de la tabla -->
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Id</th>
                                <th class="py-2 px-4 bg-gray-200 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider w-96">Descripción</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <!-- El cuerpo de la tabla -->
                        <tbody>
                            <!-- Aquí irían las filas de la tabla, iteradas con un bucle -->
                            @if (!empty($centroDeCostos) && count($centroDeCostos) > 0)
                                @php $contador = 1; @endphp
                                @foreach ($centroDeCostos as $resultado)
                                    <tr>
                                        <td class="px-2 py-1 border-b text-center">{{ $resultado->Id_cc }}</td>
                                        <td class="px-2 py-1 border-b text-left">{{ $resultado->Descripcion }}</td>
                                        <td class="px-2 py-1 border-b text-center">
                                            <button  
                                                class="mt-4 px-4 py-2 rounded block text-center 
                                                    @if($selector == $contador) 
                                                        bg-blue-500 hover:bg-blue-700 text-white 
                                                    @else 
                                                        bg-teal-500 hover:bg-teal-700 text-white 
                                                    @endif" 
                                                wire:click.prevent="seleccionar({{ $contador }})"
                                            >
                                                Selecc.
                                            </button>
                                        </td>
                                    </tr>
                                    @php $contador++; @endphp
                                @endforeach
                            @else 
                                <tr>
                                    <td colspan="2" class="py-4 px-4 text-center text-gray-600">
                                        No se encontraron resultados para la búsqueda.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
        
                <!-- Botones de acción -->
                <div class="flex justify-end mt-6 space-x-2">
                    <x-button wire:click="$set('openModal', false)" label="Cancelar" primary />
                    <x-button wire:click="submit" label="Aceptar" primary />
                </div>
        
            </div>
        </x-card>        
    </x-modal>
</div>
