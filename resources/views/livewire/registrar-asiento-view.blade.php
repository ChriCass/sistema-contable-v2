<div>
    <x-card>
        <h1 class="font-bold">Esta es la vista de registro de asiento</h1>
    </x-card>

    <x-card class="p-4 w-full my-3">
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <!-- Campo LIBRO -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">LIBRO:</span>
                    <x-select class="flex-1 w-full" :options="$libro" option-value="N" option-label="DESCRIPCION" id="libro"
                              wire:model="libro" placeholder="Seleccionar tipo de libro" />
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
                    <x-select class="flex-1 w-full" :options="$moneda" option-value="COD" option-label="COD" id="moneda"
                              wire:model="moneda" placeholder="Moneda" />
                </div>
            </div>
        </div>
    </x-card>
    
    

    <!-- Sección de Tabla con Scroll -->
    <x-card class="p-4 w-full overflow-x-auto" x-data="asientoManager()">
        <table class="min-w-full bg-white rounded shadow">
            <thead class="bg-teal-600 text-white">
                <tr>
                    <th class="p-2 text-left w-48">CNTA</th>
                    <th class="p-2 text-left w-48">DESCRIPCIÓN</th>
                    <th class="p-2 text-left w-20">DEBE S/</th>
                    <th class="p-2 text-left w-20">HABER S/</th>
                    <th class="p-2 text-left w-20">DEBE $</th>
                    <th class="p-2 text-left w-20">HABER $</th>
                    <th class="p-2 text-left w-16">T.C</th>
                    <th class="p-2 text-left w-48">GLOSA ESPECÍFICA</th>
                    <th class="p-2 text-left w-32">NUMERO</th>
                    <th class="p-2 text-left w-48">RAZ SOCIAL</th>
                    <th class="p-2 text-left w-20">TDOC</th>
                    <th class="p-2 text-left w-16">SER</th>
                    <th class="p-2 text-left w-16">NUM</th>
                    <th class="p-2 text-left w-16">N. PAG</th>
                    <th class="p-2 text-left w-32">T. PAGO</th>
                    <th class="p-2 text-left w-48">DESCRIPCIÓN</th>
                    <th class="p-2 text-left w-16">CC</th>
                    <th class="p-2 text-left w-16">ESTADO</th>
                    <th class="p-2 text-left w-16">ORDEN</th>
                    <th class="p-2 text-left w-16">ACCION</th>

                </tr>
            </thead>
            <tbody>
                @foreach($rows as $index => $row)
                    <tr>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.cn" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.descripcion" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.debe_soles" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.haber_soles" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.debe_dolares" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.haber_dolares" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.tc" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.glosa_especifica" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.numero" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.razon_social" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.tdoc" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.serie" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.num" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.npag" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.tpago" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.descripcion_pago" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.cc" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.estado" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <input type="text" wire:model.defer="rows.{{ $index }}.orden" class="w-full border-none">
                        </td>
                        <td class="p-2 border">
                            <button class="ml-2 text-green-500 shadow-lg hover:shadow-xl rounded-full" wire:click="saveEdit">✔️</button>
                            <button class="ml-2 text-red-500 shadow-lg hover:shadow-xl rounded-full" wire:click="cancelEdit">❌</button>
                        </td>                        
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button class="mt-4 bg-teal-600 text-white py-2 px-4 rounded shadow" wire:click="addRow">
            Insertar otra fila
        </button>
        <button class="mt-4 bg-green-600 text-white py-2 px-4 rounded shadow" wire:click="saveRows">
            Guardar Filas
        </button>
    </x-card>

    
</div>
