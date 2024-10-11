<div>
    <!-- Alerts -->
@if ($statusType === 'success')
<x-alert title="Success" positive padding="small">
    <x-slot name="slot">
        {{ $statusMessage }}
    </x-slot>
</x-alert>
@elseif ($statusType === 'danger')
<x-alert title="Error" negative padding="small">
    <x-slot name="slot">
        {{ $statusMessage }}
    </x-slot>
</x-alert>
@endif

    <div class="container mx-auto px-4">
        <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-full">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">
                    <strong>Vista</strong> Previa
                </h2>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        @if (!empty($data))
                        <tr>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Empresa</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Libro</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Fecha Doc</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Fecha Ven</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Correntista</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Razon Social</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tdoc</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Ser</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Num</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cod Moneda</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tip Cam</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Opigv</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Bas Imp</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Igv</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No Gravadas</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Isc</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Imp Bol Pla</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Otro Tributo</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Precio</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Glosa</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cuenta 1</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cuenta 2</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cuenta 3</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cuenta precio</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Mon1</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Mon2</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Mon3</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cc1</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cc2</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cc3</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cuenta otro tributo</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Fecha de modificación</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tipo de documento modificado</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Serie modificada</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Número Modificado</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Fecha de emisión de detracción</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Número constancia de detracción</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">¿Tiene detracción?</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cuenta detracción</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Monto detracción</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Ref Int1</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Ref Int2</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Ref Int3</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Estado Doc</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Estado</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Acción</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Usuario</th>
                        </tr>
                        @endif
                    </thead>
                    
                    <tbody>
                        @if (!empty($data))
                            @foreach ($data as $index => $dataItem)
                                <tr>
                                    <td class="px-2 py-1 border-b text-center">{{ $index ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $libros->where('N', $dataItem['libro'])->first()->DESCRIPCION ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['fecha_doc'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['fecha_ven'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['correntistaData']['dni'] ?? ($dataItem['correntistaData']['ruc_emisor'] ?? '-') }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['correntistaData']['nombre'] ?? ($dataItem['correntistaData']['nombre_o_razon_social'] ?? '-') }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $ComprobantesPago->where('N', $dataItem['tdoc'])->first()->DESCRIPCION ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['ser'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['num'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cod_moneda'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['tip_cam'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $opigvs->where('Id', $dataItem['opigv'])->first()->Descripcion ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cod_moneda'] == 'USD' ? $montoDolares['bas_imp'] : $dataItem['bas_imp'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cod_moneda'] == 'USD' ? $montoDolares['igv'] : $dataItem['igv'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['no_gravadas'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['isc'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['imp_bol_pla'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cod_moneda'] == 'USD' ? $montoDolares['otro_tributo'] : $dataItem['otro_tributo'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['precio'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['glosa'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cnta1'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cnta2'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cnta3'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cnta_precio'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cod_moneda'] == 'USD' ? $montoDolares['mon1'] : $dataItem['mon1'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cod_moneda'] == 'USD' ? $montoDolares['mon2'] : $dataItem['mon2'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cod_moneda'] == 'USD' ? $montoDolares['mon3'] : $dataItem['mon3'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cc1'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cc2'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cc3'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cta_otro_t'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['fecha_emod'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['tdoc_emod'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['ser_emod'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['num_emod'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['fec_emi_detr'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['num_const_der'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['tiene_detracc'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['cta_detracc'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['mont_detracc'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['ref_int1'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['ref_int2'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['ref_int3'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $estado_docs->where('id', $dataItem['estado_doc'])->first()->descripcion ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $estados->where('N', $dataItem['estado'])->first()->DESCRIPCION ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center flex flex-col gap-3">
                                        <div wire:ignore>
                                            @livewire('edit-compra-venta-form', ['index' => $index, 'dataItem' => $dataItem])
                                        </div>
                                        

                                        <x-button
                                        negative
                                         
                                        icon="trash"
                                        wire:click="NoMoreRow({{ $index }})"
                                    >
                                        Eliminar
                                    </x-button>
                                    
                                    </td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['usuario'] ?? '-' }}</td>
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
            <div class="flex justify-center p-4 mt-4">
                <button type="submit" class="mt-4 bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-700 block text-center"
                    @if (empty($data)) disabled @endif wire:click="insertData">Insertar
                    Información</button>
            </div>
        </div>
    </div>

    <h2>Data Received</h2>
    <pre>{{ print_r($data, true) }}</pre>

    <div>
        <h2>Data from Uploaded Files</h2>
        <pre>{{ print_r($data, true) }}</pre>
    
        <!-- Tu tabla de compra-venta aquí -->
    </div>
    
</div>
