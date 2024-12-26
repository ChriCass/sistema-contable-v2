<div>
    <x-card>
        <h2 class="text-lg font-bold">
            {{ $origen }}
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
    @if ($origen =='ventas')
        <div class="mt-5">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">ACCIONES</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">VOU</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">FECHA DE EMISION</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">FECHA DE VENCIMIENTO</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">TIPO DE DOCUMENTO</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">SERIE</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">NUMERO</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">ULTIMO</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">TIP DOC IDENTIDAD</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">RUC</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">RAZ SOCIAL</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">BASE IMPONIBLE</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">DESCUENTO A BASE IMPONIBLE</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">IGV</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">DESCUENTO IGV</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">NO GRAVADAS</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">ISC</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">IMP BOL PLA</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">OTRO TRIBUTO</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">TOTAL</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">COD MONEDA</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">TIPO DE CAMBIO</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">FEC DOC MOD</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">TIPO DOC MOD</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">SERIE DOC MOD</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">COD DEPENDENCIA DUA</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">NUMERO DOC MOD</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">FECHA CONST DETRA</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">NUMERO CONST DETRA</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">CLASES BIENES</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">GLOSA GENERAL</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">DOCUMENTO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($dataArray))
                                    @foreach ($dataArray as $voucher)
                                    <tr>
                                        <td class="px-2 py-1 border-b text-center">
                                            <x-button icon="pencil" label="Editar" wire:navigate href="{{ route('empresa.registrar-asiento', ['id' => $empresa->id, 'origen' => 'editar_asiento', 'libro' => $libro[0]->id, 'mes' => $mss, 'vou' => $voucher->Vou]) }}"/>
                                        </td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->Vou}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->Fecha_Doc}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->Fecha_Ven}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->TDoc}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->Ser}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->Num}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->ultimo}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->idt02doc}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->ruc_emisor}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->nombre_o_razon_social}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->grav}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->descu}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->gravigv}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->descuigv}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->NoGravadas}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->ISC}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->ImpBolPla}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->OtroTributo}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->total}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->CodMoneda}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->TipCam}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->FechaEMod}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->TDocEMod}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->SerEMod}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->CodDepenDUAoDSI}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->NumEMod}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->FecEmiDetr}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->NumConstDer}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->ClasBienes}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->GlosaGeneral}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->descripcion}}</td>
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
    @else
        <div class="mt-5">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">ACCIONES</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">VOU</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">FECHA DE EMISION</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">FECHA DE VENCIMIENTO</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">TIPO DE DOCUMENTO</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">SERIE</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">NUMERO</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">ULTIMO</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">TIP DOC IDENTIDAD</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">RUC</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">RAZ SOCIAL</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">BASE IMPONIBLE 1</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">IGV 1</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">BASE IMPONIBLE 2</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">IGV 2</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">BASE IMPONIBLE 3</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">IGV 3</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">NO GRAVADAS</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">ISC</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">IMP BOL PLA</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">OTRO TRIBUTO</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">TOTAL</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">COD MONEDA</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">TIPO DE CAMBIO</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">FEC DOC MOD</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">TIPO DOC MOD</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">SERIE DOC MOD</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">COD DEPENDENCIA DUA</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">NUMERO DOC MOD</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">FECHA CONST DETRA</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">NUMERO CONST DETRA</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">CLASES BIENES</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">GLOSA GENERAL</th>
                                    <th class="py-2 px-4 bg-gray-200 text-xs font-semibold text-gray-700 uppercase">DOCUMENTO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($dataArray))
                                    @foreach ($dataArray as $voucher)
                                    <tr>
                                        <td class="px-2 py-1 border-b text-center">
                                            <x-button icon="pencil" label="Editar" wire:navigate href="{{ route('empresa.registrar-asiento', ['id' => $empresa->id, 'origen' => 'editar_asiento', 'libro' => $libro[0]->id, 'mes' => $mss, 'vou' => $voucher->Vou]) }}"/>
                                        </td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->Vou}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->Fecha_Doc}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->Fecha_Ven}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->TDoc}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->Ser}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->Num}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->Ultimo}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->idt02doc}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->ruc_emisor}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->nombre_o_razon_social}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->grav}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->gravigv}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->grav1}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->gravigv1}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->grav2}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->gravigv2}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->NoGravadas}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->ISC}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->ImpBolPla}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->OtroTributo}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->total}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->CodMoneda}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->TipCam}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->FechaEMod}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->TDocEMod}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->SerEMod}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->CodDepenDUAoDSI}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->NumEMod}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->FecEmiDetr}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->NumConstDer}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->ClasBienes}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->GlosaGeneral}}</td>
                                        <td class="px-2 py-1 border-b text-center">{{$voucher->descripcion}}</td>
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
    @endif
</div>
