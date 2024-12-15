<div>
    <x-card>
        <h1 class="font-bold">{{$tipForm}}</h1>
    </x-card>
      
    <x-card class="p-4 w-full mt-5">
        @if (session()->has('error'))
            <x-alert title="Error!" negative class="mb-3">
                {{ session('error') }}
            </x-alert>
        @endif
        @if(session()->has('message'))
            <x-alert title="¡Transacción Exitosa!" class="mb-3" positive padding="none">
                    {{ session('message') }} — <b>¡verifícalo!</b>
            </x-alert>
        @endif
        
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <!-- Campo LIBRO -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">LIBRO:</span>
                    <x-select class="flex-1 w-full" :options="$libro" option-value="N" option-label="DESCRIPCION"
                        id="libro" wire:model="lib" placeholder="Seleccionar tipo de libro" />
                </div>

                <!-- Campo MES -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">MES:</span>
                    <x-select class="flex-1 w-full" :options="$mes" option-value="N" option-label="MES" id="mes"
                        wire:model="mss" placeholder="Meses" />
                </div>

                <!-- Campo FECHA -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">FECHA:</span>
                    <x-datetime-picker class="flex-1 w-full" without-time placeholder="ingresar una fecha valida" id="fecha_ven"
                        wire:model="fecha_vaucher" required />
                </div>

                <!-- Campo GLOSA GEN -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">GLOSA GEN:</span>
                    <x-input class="flex-1 w-full" wire:model="glosa" oninput="this.value = this.value.toUpperCase()"></x-input>
                </div>

                <!-- Campo MONEDA -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">MONEDA:</span>
                    <x-select class="flex-1 w-full" :options="$moneda" option-value="COD" option-label="COD"
                        id="moneda" wire:model="mon" placeholder="Moneda" />
                </div>
            </div>

      
        </div>
        <div x-data="{ openForm: @entangle('openForm') }">
            <button @click="$wire.set('openForm', !openForm)"
                :class="openForm ? 'bg-yellow-500 text-white' : 'bg-blue-500 text-white'"
                class="px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 mt-4">
                <span x-text="openForm ? 'Ocultar formulario' : 'Agregar Fila'"></span>
            </button>
            <div x-show="openForm" class="mt-5" x-transition>
                @livewire('reusable-form', ['tra' => $tra])
            </div>
        </div>
    </x-card>

    <div  class="mt-5">
        <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-full">
            <div class="p-4 overflow-x-auto">
                <div class="flex gap-3   mb-4">
                    <div>
                        <x-alert title="Debe: {{$de}}" />
                    </div>
                    <div>
                        <x-alert title="Haber: {{$ha}}" secondary/>
                    </div>
                    <div>
                        @if ($to != 0)
                            <x-alert title="Diferencia: {{$to}}" danger />
                        @else
                            <x-alert title="Diferencia: {{$to}}" positive />
                        @endif
                    </div>
                    
                </div>
                
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">CNTA</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DESCRIPCION</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DEBE S/</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">HABER S/</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DEBE $</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">HABER $</th>
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
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ACCIONES</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @if (!empty($dataAsiento))
                            @foreach ($dataAsiento as $index => $dataItem)
                                <tr>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['Cnta'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['DesCnta'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['DebeS'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['HaberS'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['DebeD'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['HaberD'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['GlosaEspecifica'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['Corrent'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['RazSocial'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['Tdoc'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['Ser'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['Num'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['Mpag'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['CC'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['estado'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['estado_doc'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center flex flex-col gap-3">
                                        <x-button icon="pencil" wire:click="EditarFila({{ $index }})">Editar</x-button>
                                        <x-button negative icon="trash" wire:click="EliminarFila({{ $index }})">Eliminar</x-button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="47" class="px-2 py-1 border-b text-center">¡Mostraremos aquí la info!</td>
                            </tr>
                        @endif

                    </tbody>
                    
                </table>
            </div>
            <div class="my-4 flex justify-center">
                <x-button teal label="Procesar" wire:click="Procesar"/>
            </div>
        </div>
    </div>




</div>
