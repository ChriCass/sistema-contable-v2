<div>
    <x-card>
        <h1 class="font-bold">Hoja de Trabajo</h1>
    </x-card>

    <x-card class="p-4 mb-4">
        <div class="flex items-center space-x-4">
            <div class="flex items-center">
                <x-select label="Mes" class="w-full" :options="$mes" option-value="N" option-label="MES"
                        id="mes" wire:model="mss" placeholder="Meses" />
            </div>
         
                <div class="flex items-center space-x-2">
                    <input type="radio" name="mes" value="x Mes" wire:model="tipoMes" checked>
                    <label class="text-sm">x Mes</label>
                    <input type="radio" name="mes" value="hasta Mes" wire:model="tipoMes">
                    <label class="text-sm">hasta Mes</label>
                </div>
                <button class="bg-blue-600 text-white py-2 px-6 rounded shadow-lg" wire:click="procesar">
                    Procesar
                </button>
            </div>
            
 
    </x-card>

    <div class="mt-5">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-4 overflow-x-auto">
                @if (session()->has('error'))
                    <x-alert title="Error!" negative class="mb-3">
                        {{ session('error') }}
                    </x-alert>
                @endif
                <table class="min-w-full bg-white border border-gray-200">                
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 border-b">ACCION</th>
                            <th class="px-4 py-2 border-b">CUENTA</th>
                            <th class="px-4 py-2 border-b">DESCRIPCION</th>
                            <th class="px-4 py-2 border-b">DEBE</th>
                            <th class="px-4 py-2 border-b">HABER</th>
                            <th class="px-4 py-2 border-b">MAYOR DEBE</th>
                            <th class="px-4 py-2 border-b">MAYOR HABER</th>
                            <th class="px-4 py-2 border-b">AJUSTE 79 DEBE</th>
                            <th class="px-4 py-2 border-b">AJUSTE 79 HABER</th>
                            <th class="px-4 py-2 border-b">ESF DEBE</th>
                            <th class="px-4 py-2 border-b">ESF HABER</th>
                            <th class="px-4 py-2 border-b">ERN DEBE</th>
                            <th class="px-4 py-2 border-b">ERN HABER</th>
                            <th class="px-4 py-2 border-b">ERF DEBE</th>
                            <th class="px-4 py-2 border-b">ERF HABER</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($result))
                            @foreach($result as $res)
                                <tr>
                                    @if ($res->orden == '1')
                                        <td class="px-4 py-2 border-b">
                                            <x-button wire:navigate
                                                href="{{ route('empresa.hoja-trabajo-analisis', ['tipoDeCuenta' => $res->Tipo,'cuenta' => $res->CtaCtable,'mes'=>$mss,'tipoMes' => $tm, 'id' => $empresa->id]) }}"
                                                label="Analizar" primary />
                                        </td>
                                    @else
                                    <td class="px-4 py-2 border-b"> </td>
                                    @endif
                                    <td class="px-4 py-2 border-b">{{$res->CtaCtable}}</td>
                                    <td class="px-4 py-2 border-b">{{$res->Descripcion}}</td>
                                    <td class="px-4 py-2 border-b">{{$res->debe}}</td>
                                    <td class="px-4 py-2 border-b">{{$res->haber}}</td>
                                    <td class="px-4 py-2 border-b">{{$res->Mdebe}}</td>
                                    <td class="px-4 py-2 border-b">{{$res->Mhaber}}</td>
                                    <td class="px-4 py-2 border-b">{{$res->Aj79D}}</td>
                                    <td class="px-4 py-2 border-b">{{$res->Aj79H}}</td>
                                    <td class="px-4 py-2 border-b">{{$res->EsfD}}</td>
                                    <td class="px-4 py-2 border-b">{{$res->EsfH}}</td>
                                    <td class="px-4 py-2 border-b">{{$res->ErnD}}</td>
                                    <td class="px-4 py-2 border-b">{{$res->ErnH}}</td>
                                    <td class="px-4 py-2 border-b">{{$res->ErfD}}</td>
                                    <td class="px-4 py-2 border-b">{{$res->ErfH}}</td>
                                    
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
        </div>
    </div>
</div>
