<div>
    <x-card>
        <h2 class="text-lg font-bold">Gestión de Asientos Contables</h2>
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
                            <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">MES</th>
                            <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">LIBRO</th>
                            <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">VOUCHER</th>
                            <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">FECHA</th>
                            <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">GLOSA GENERAL</th>
                            <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">ACCIONES</th>
                        </tr>
                        
                    </thead>
               <tbody>
                    @if (!empty($dataAsiento))
                        @foreach ($dataAsiento as $dataItem)
                            <tr>
                                <td class="px-2 py-1 border-b text-center">{{ $dataItem->MES ?? '-' }}</td>
                                <td class="px-2 py-1 border-b text-center">{{ $dataItem->DESCRIPCION ?? '-' }}</td>
                                <td class="px-2 py-1 border-b text-center">{{ $dataItem->Vou ?? '-' }}</td>
                                <td class="px-2 py-1 border-b text-center">{{ $dataItem->Fecha_Vou ?? '-' }}</td>
                                <td class="px-2 py-1 border-b text-center">{{ $dataItem->GlosaGeneral ?? '-' }}</td>
                                <td class="px-2 py-1 border-b text-center">
                                    <x-button icon="pencil" label="Editar" wire:navigate href="{{ route('empresa.registrar-asiento', ['id' => $empresa->id, 'origen' => 'editar_asiento', 'libro' => $dataItem->id, 'mes' => $dataItem->idMes, 'vou' => $dataItem->Vou]) }}"/>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-2 py-1 border-b text-center">¡No se encontraron resultados!</td>
                        </tr>
                    @endif
                </tbody>
                
                </table>
            </div>
        </div>
    </div>
</div>
