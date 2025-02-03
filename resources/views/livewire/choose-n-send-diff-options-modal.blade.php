<div>
    <x-button label="Selecc." wire:click="$set('openModal', true)" primary />

    <x-modal name="persistentModal" wire:model="openModal">

        <x-card title="Cuadro De Pendientes">
            <div class="p-4">
                <!-- Mostrar los mensajes aquí -->
                @if (session()->has('message'))
                    <x-alert title="Felicidades!" positive>
                        {{ session('message') }}
                    </x-alert>
                @elseif (session()->has('warning'))
                    <x-alert title="Advertencia!" warning>
                        {{ session('warning') }}
                    </x-alert>
                @elseif (session()->has('error'))
                    <x-alert title="Error!" negative>
                        {{ session('error') }}
                    </x-alert>
                @endif

                <div class="w-full">
                    <h4 class="font-bold mb-3">Cuenta:</h4>
                </div>

                <div class="flex flex-wrap -mx-2 mt-4">
                    <x-input placeholder="Buscar..." wire:model.live="cuenta"></x-input>
                </div>

                <div class="flex flex-wrap -mx-2 mt-4">
                    <h4 class="font-bold mb-3">Filtro:</h4>
                    <div class="w-full px-2">
                        <select id="filterColumn" 
                                x-data 
                                x-ref="filterColumn" 
                                @change="$wire.set('filterColumn', $refs.filterColumn.value).then(() => $wire.applyFilters())" 
                                class="w-full mb-3 p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            <option value="nombre_o_razon_social">RAZON SOCIAL</option>
                            <option value="TDoc">T. DOC</option>
                            <option value="ruc_emisor">RUC</option>
                        </select>
                    
                        <x-input id="searchInput" 
                                 x-data 
                                 x-ref="searchInput" 
                                 @input.debounce.500ms="$wire.set('searchValue', $refs.searchInput.value).then(() => $wire.applyFilters())" 
                                 placeholder="Buscar..." />
                    </div>
                </div>
                

                <div class="overflow-x-auto mt-5">
                    <table id="pendientesTable" class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ACCION</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">RUC</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">RAZON SOCIAL</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">T. DOC</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">SERIE</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NUMERO</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">CUENTA</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NOMBRE CUENTA</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DEBE</th>
                                <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">HABER</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200 text-sm">
                                        <button wire:click="toggleSelection({{ $d->id }})"
                                            class="{{ collect($contenedor)->contains('id', $d->id) ? 'bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded' : 'bg-teal-500 hover:bg-teal-700 text-white py-2 px-4 rounded' }}">
                                            {{ collect($contenedor)->contains('id', $d->id) ? 'Quitar' : 'Seleccionar' }}
                                        </button>
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $d->ruc_emisor }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $d->nombre_o_razon_social }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $d->TDoc }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $d->Ser }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $d->Num }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $d->CtaCtable }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $d->Descripcion }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $d->Debe }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $d->Haber }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>

                <div class="flex justify-end mt-4 space-x-2">
                    <x-button flat label="Cancelar" wire:click="$set('openModal', false)" />
                    <x-button label="Aceptar" wire:click="sendingData" primary />
                </div>
            </div>
        </x-card>
    </x-modal>
</div>

 