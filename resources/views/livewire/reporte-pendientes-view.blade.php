<div>
    <x-card class="mb-3">
        <h1 class="font-bold">Pendientes</h1>
    </x-card>
    <div>
        <x-card class="p-4 mb-4">
            @if (session()->has('error'))
                <x-alert title="Error!" negative class="mb-3">
                    {{ session('error') }}
                </x-alert>
            @endif
                
            <div class="flex items-center space-x-4">
                <!-- Botón -->
                <button class="bg-blue-600 text-white py-2 px-6 rounded shadow-lg" wire:click="PlanCont(14)">
                    Plan de Cuentas
                </button>
                @livewire('cuadro-de-cuentas')
        
                <!-- Campo de entrada -->
                <div class="w-64">
                    <x-input type="text" 
                    id="cuentaId" 
                    wire:model="cuentaId" 
                    required 
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                </div>
        
                <!-- Radios -->
                <div class="flex items-center space-x-2">
                    <input type="radio" name="mes" value="Pendientes" wire:model="tipoPag" checked>
                    <label class="text-sm">Pendientes</label>
                    <input type="radio" name="mes" value="Pagado" wire:model="tipoPag">
                    <label class="text-sm">Pagado</label>
                </div>
    
                <!-- Botón de procesar -->
                <button class="bg-blue-600 text-white py-2 px-6 rounded shadow-lg" wire:click="Procesar">
                    Procesar
                </button>
            </div>
        </x-card>
    </div>
        
    @if(!empty($result))
        <x-card class="p-4 mb-4">
            @if(count($result) <> 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border-b">ACCION</th>
                                <th class="px-4 py-2 border-b">MES</th>
                                <th class="px-4 py-2 border-b">LIBRO</th>
                                <th class="px-4 py-2 border-b">FECHA EMISION</th>
                                <th class="px-4 py-2 border-b">FECHA VENCIMIENTO</th>
                                <th class="px-4 py-2 border-b">TIP DOC</th>
                                <th class="px-4 py-2 border-b">SERIE</th>
                                <th class="px-4 py-2 border-b">NUMERO</th>
                                <th class="px-4 py-2 border-b">CORRENTISTA</th>
                                <th class="px-4 py-2 border-b">RAZON SOCIAL</th>
                                <th class="px-4 py-2 border-b">CUENTA</th>
                                <th class="px-4 py-2 border-b">DESCRIPCION</th>
                                <th class="px-4 py-2 border-b">MONTO SOLES</th>
                                <th class="px-4 py-2 border-b">MONTO DOLARES</th>                        
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($result as $res)
                            <tr>
                                <td class="px-4 py-2 border-b">
                                    <x-button wire:navigate
                                        href="{{ route('empresa.detalle', ['id' => $empresa->id, 'cuenta' => $res->Cnta, 'correntista' => $res->corrent, 'tdoc' => $res->TDoc, 'serie' => $res->Ser, 'numero' => $res->Num])}}"
                                        label="Analizar" primary />
                                </td>
                                <td class="px-4 py-2 border-b">{{$res->Mes}}</td>
                                <td class="px-4 py-2 border-b">{{$res->Libro}}</td>
                                <td class="px-4 py-2 border-b">{{$res->Fecha_Doc}}</td>
                                <td class="px-4 py-2 border-b">{{$res->Fecha_Ven}}</td>
                                <td class="px-4 py-2 border-b">{{$res->TDoc}}</td>
                                <td class="px-4 py-2 border-b">{{$res->Ser}}</td>
                                <td class="px-4 py-2 border-b">{{$res->Num}}</td>
                                <td class="px-4 py-2 border-b">{{$res->corrent}}</td>
                                <td class="px-4 py-2 border-b">{{$res->nombre_o_razon_social}}</td>
                                <td class="px-4 py-2 border-b">{{$res->Cnta}}</td>
                                <td class="px-4 py-2 border-b">{{$res->Descripcion}}</td>
                                <td class="px-4 py-2 border-b">{{$res->MontoSoles}}</td>
                                <td class="px-4 py-2 border-b">{{$res->MontDolares}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h1 class="font-bold">No existen datos que mostrar</h1>
            @endif
        </x-card>
    
    @endif
    
    
    
</div>
