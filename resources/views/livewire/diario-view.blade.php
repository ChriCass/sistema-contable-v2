<div>
    <x-card class="mb-3">
        <h1 class="font-bold">diario</h1>
    </x-card>
    <x-card class="p-4 mb-4">
        <div class="flex items-center space-x-4">
            <div class="flex items-center">
                <label class="mr-2 text-sm font-bold">MES:</label>
                <input type="text" class="border border-gray-300 rounded p-2" wire:model="mes">
            </div>
            <div class="flex items-center space-x-2">
                <input type="radio" name="mes" value="x Mes" wire:model="tipoMes" checked>
                <label class="text-sm">x Mes</label>
                <input type="radio" name="mes" value="hasta Mes" wire:model="tipoMes">
                <label class="text-sm">hasta Mes</label>
            </div>
            <button class="bg-blue-600 text-white py-2 px-6 rounded shadow-lg" wire:click="procesarDiario">
                Procesar
            </button>
            <x-button outline warning :disabled="empty($result)" wire:click="deleteResult">
                Vaciar tabla
            </x-button>
            
        </div>
    </x-card>

     <!-- Mostrar las alertas según el mensaje de la sesión -->
     @if (session()->has('success'))
     <x-alert title="Success!" positive padding="none" class="pl-1 mt-1 ml-3">
         <x-slot name="slot">
             {{ session('success') }}
         </x-slot>
     </x-alert>
 @endif

 @if (session()->has('error'))
     <x-alert title="Error!" negative padding="small" class="pl-1 mt-1 ml-3">
         <x-slot name="slot">
             {{ session('error') }}
         </x-slot>
     </x-alert>
 @endif


    <!-- Sección de la Tabla de datos con Scroll -->
    <x-card class="p-4 overflow-x-auto">
        <table class="min-w-full bg-white rounded shadow">
            <thead class="bg-teal-600 text-white">
                <tr>
                    <th class="p-2 text-left">MES</th>
                    <th class="p-2 text-left">LIBRO</th>
                    <th class="p-2 text-left">VOU</th>
                    <th class="p-2 text-left">CUENT</th>
                    <th class="p-2 text-left">DESCRIPCION</th>
                    <th class="p-2 text-left">DEBE</th>
                    <th class="p-2 text-left">HABER</th>
                    <th class="p-2 text-left">DEBE</th>
                    <th class="p-2 text-left">HABER</th>
                    <th class="p-2 text-left">TIP CAMBIO</th>
                    <th class="p-2 text-left">GLOSA</th>
                    <th class="p-2 text-left">CORRE</th>
                    <th class="p-2 text-left">NOMBRE / RAZON SOCIAL</th>
                    <th class="p-2 text-left">T DOC</th>
                    <th class="p-2 text-left">SER</th>
                    <th class="p-2 text-left">NUMER</th>
                    <th class="p-2 text-left">CC</th>
                    <th class="p-2 text-left">REFER</th>
                    <th class="p-2 text-left">ESTADO</th>
                    <th class="p-2 text-left">ID ESTADO DOC</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @if (!empty($result))
                    @foreach($result as $row)
                        <tr>
                            <td class="p-2">{{ $row->Mes }}</td>
                            <td class="p-2">{{ $row->Libro }}</td>
                            <td class="p-2">{{ $row->Vou }}</td>
                            <td class="p-2">{{ $row->Cnta }}</td>
                            <td class="p-2">{{ $row->Descripcion }}</td>
                            <td class="p-2">{{ $row->Debe }}</td>
                            <td class="p-2">{{ $row->Haber }}</td>
                            <td class="p-2">{{ $row->DebeDo }}</td>
                            <td class="p-2">{{ $row->HaberDo }}</td>
                            <td class="p-2">{{ $row->TipCam }}</td>
                            <td class="p-2">{{ $row->GlosaEpecifica }}</td>
                            <td class="p-2">{{ $row->Corrent }}</td>
                            <td class="p-2">{{ $row->nombre_o_razon_social }}</td>
                            <td class="p-2">{{ $row->TDoc }}</td>
                            <td class="p-2">{{ $row->Ser }}</td>
                            <td class="p-2">{{ $row->Num }}</td>
                            <td class="p-2">{{ $row->CC }}</td>
                            <td class="p-2">{{ $row->RefInt }}</td>
                            <td class="p-2">{{ $row->Estado }}</td>
                            <td class="p-2">{{ $row->idEstadoDoc }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="p-2 text-center" colspan="20">
                            No registros, prueba procesando en la caja de filtros.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </x-card>
</div>
