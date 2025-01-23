<div>
    <x-card class="mb-3">
        <h1 class="font-bold">Detalle</h1>
    </x-card>
    <x-card class="p-4 mb-4">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 border-b">MES</th>
                        <th class="px-4 py-2 border-b">LIBRO</th>
                        <th class="px-4 py-2 border-b">VOUCHER</th>
                        <th class="px-4 py-2 border-b">FECHA EMISION</th>
                        <th class="px-4 py-2 border-b">FECHA VENCIMIENTO</th>
                        <th class="px-4 py-2 border-b">CORRENTISTA</th>
                        <th class="px-4 py-2 border-b">RAZON SOCIAL</th>
                        <th class="px-4 py-2 border-b">TIP DOC</th>
                        <th class="px-4 py-2 border-b">SERIE</th>
                        <th class="px-4 py-2 border-b">NUMERO</th>
                        <th class="px-4 py-2 border-b">CUENTA</th>
                        <th class="px-4 py-2 border-b">DESCRIPCION</th>
                        <th class="px-4 py-2 border-b">MONTO SOLES</th>
                        <th class="px-4 py-2 border-b">MONTO DOLARES</th>                        
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($result))
                        @foreach($result as $res)
                        <tr>
                            <td class="px-4 py-2 border-b">{{$res->Mes}}</td>
                            <td class="px-4 py-2 border-b">{{$res->Libro}}</td>
                            <td class="px-4 py-2 border-b">{{$res->Vou}}</td>
                            <td class="px-4 py-2 border-b">{{$res->Fecha_Vou}}</td>
                            <td class="px-4 py-2 border-b">{{$res->Fecha_Doc}}</td>
                            <td class="px-4 py-2 border-b">{{$res->Fecha_Ven}}</td>
                            <td class="px-4 py-2 border-b">{{$res->Corrent}}</td>
                            <td class="px-4 py-2 border-b">{{$res->nombre_o_razon_social}}</td>
                            <td class="px-4 py-2 border-b">{{$res->tdoc}}</td>
                            <td class="px-4 py-2 border-b">{{$res->Ser}}</td>
                            <td class="px-4 py-2 border-b">{{$res->Num}}</td>
                            <td class="px-4 py-2 border-b">{{$res->Cnta}}</td>
                            <td class="px-4 py-2 border-b">{{$res->Descripcion}}</td>
                            <td class="px-4 py-2 border-b">{{$res->MontSoles}}</td>
                            <td class="px-4 py-2 border-b">{{$res->MontDolares}}</td>
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
    </x-card>
</div>
