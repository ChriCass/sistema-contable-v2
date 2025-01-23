<div>
   
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __(ucfirst(str_replace('.', ' ', request()->route()->getName()))) }}
    </h2>
    
    </x-slot>
<main class="w-full px-4 mx-auto mt-5">
    <x-card >
        <div class="overflow-x-auto">
            @if ($tipoDeCuenta == 'ANA')
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">CUENTA</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">DESCRIPCION</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">RUC</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">RAZON SOCIAL</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">TIPO DE DOCUMENTO</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">SERIE</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">NUMERO</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">MONTO SOLES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($result))
                            @foreach ($result as $res)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $res->CtaCtable }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->Descripcion }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->ruc_emisor }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->nombre_o_razon_social }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->tdoc }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->Ser }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->Num }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->MontSoles }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="px-4 py-2 border-b text-center">No hay movimientos disponibles</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            @else
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">MES</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">LIBRO</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">VOU</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">FECHA VOUCHER</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">CUENTA</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">DESCRIPCION</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">DEBE</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">HABER</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">GLOSA ESPECIFICA</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">RUC</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">RAZON SOCIAL</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">TDOC</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">SER</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">NUM</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">CC</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">DESCRIPCION CC</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">REFERENCIA INTERNA</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ESTADO</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ESTADO DESCRIPCION</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ESTADO DOC</th>
                            <th class="px-4 py-2 border-b border-gray-300 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">DOC DESCRIIPCION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($result))
                            @foreach ($result as $res)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $res->Mes }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->N }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->Vou }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->Fecha_Vou }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->CtaCtable }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->DesCuenta }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->Debe }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->Haber }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->GlosaEpecifica }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->ruc_emisor }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->nombre_o_razon_social }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->TDoc }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->Ser }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->Num }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->CC }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->DesCC }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->RefInt }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->Estado }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->DesEsta }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->idEstadoDoc }}</td>
                                    <td class="px-4 py-2 border-b">{{ $res->DosDes }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="px-4 py-2 border-b text-center">No hay movimientos disponibles</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            @endif
            
        </div>
       <!-- Botones -->
       <div class="flex justify-end mt-4 space-x-2">
        <x-button label="Cancelar" outline secondary wire:navigate href="{{ route('empresa.hoja-trabajo', ['id' => $empresa->id]) }}" />
    
    
         <!-- Aqui habria algun boton de eliminado(?) -->
      </x-card>
</main>
  
     
</div>
