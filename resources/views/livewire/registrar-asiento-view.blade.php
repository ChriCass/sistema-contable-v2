<div>
    <x-card>
        <div class="flex items-center space-x-4">
            <h1 class="font-bold">{{$tipForm}}</h1>
            @if ($origen == 'editar_asiento')
                <x-button class="bg-red-500 hover:bg-red-600 text-white" label="Eliminar Asiento" wire:click="EliminarAsiento"/>
            @endif
        </div>
    </x-card>
      
    <x-card class="p-4 w-full mt-5">
        @if (session()->has('error'))
            <x-alert title="Error!" negative class="mb-3">
                {{ session('error') }}
            </x-alert>
        @endif
        @if(session()->has('message'))
            <x-alert title="¡Transacción Exitosa!" class="mb-3" positive padding="none">
                    {{ session('message') }} — <b>¡verifícalo!</b>
            </x-alert>
        @endif
        
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <!-- Campo LIBRO -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">LIBRO:</span>
                    <x-select class="flex-1 w-full" :options="$libro" option-value="N" option-label="DESCRIPCION"
                        id="libro" wire:model="lib" placeholder="Seleccionar tipo de libro" />
                </div>

                <!-- Campo MES -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">MES:</span>
                    <x-select class="flex-1 w-full" :options="$mes" option-value="N" option-label="MES" id="mes"
                        wire:model="mss" placeholder="Meses" />
                </div>

                <!-- Campo FECHA -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">FECHA:</span>
                    <x-datetime-picker class="flex-1 w-full" without-time placeholder="ingresar una fecha valida" id="fecha_ven"
                        wire:model="fecha_vaucher" required />
                </div>

                <!-- Campo GLOSA GEN -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">GLOSA GEN:</span>
                    <x-input class="flex-1 w-full" wire:model="glosa" oninput="this.value = this.value.toUpperCase()"></x-input>
                </div>

                <!-- Campo MONEDA -->
                <div class="text-sm font-bold flex items-center">
                    <span class="w-24">MONEDA:</span>
                    <x-select class="flex-1 w-full" :options="$moneda" option-value="COD" option-label="COD"
                        id="moneda" wire:model="mon" placeholder="Moneda" />
                </div>

                @if ($origen == 'editar_asiento')
                    <!-- Campo Vaucher -->
                    <div class="text-sm font-bold flex items-center">
                        <span class="w-24">VAUCHER:</span>
                        <x-input class="flex-1 w-full" wire:model="voucher" oninput="this.value = this.value.replace(/[^0-9]/g, '')" readonly></x-input>
                    </div>
                @endif
            </div>
        </div>

        @if ($origen == 'editar_asiento' && $conven == '1')
            <div class="w-full">
                <h4 class="font-bold mb-3 mt-5">Datos de Comprobante</h4>
            </div>
            <div class="flex flex-wrap -mx-2">
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-datetime-picker class="flex-1 w-full" without-time placeholder="ingresar una fecha valida" id="fecha_emi"
                    label="Fecha del Emision" wire:model="Fecha_Doc" required />
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-datetime-picker class="flex-1 w-full" without-time placeholder="ingresar una fecha valida" id="fecha_ven"
                    label="Fecha Vcto/Pago" wire:model="Fecha_Ven" required />
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-select :options="$TipoDeDocumentos" option-value="N" option-label="DESCRIPCION" label="T.doc"
                    placeholder="Seleccione el tipo de documento" wire:model="TDoc" />
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="Serie" wire:model="Ser"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="Año" wire:model="ADuaDsi"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="Numero" wire:model="Num"/>
                </div>

                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="Nro Final (Rango)"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-select 
                        label="Tipo Doc Identidad" 
                        :options="$TipoDeDocIdentidad" 
                        option-value="N" 
                        option-label="DESCRIPCION"
                        placeholder="Seleccione el tipo de documento" 
                        wire:model="idt02doc" 
                    />
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="Nro Doc Identidad" wire:model="ruc_emisor"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="Razón Social" wire:model="nombre_o_razon_social"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-select  label="Tip IGV" :options="$TipoOpIgv" option-value="Id" option-label="Descripcion"
                    placeholder="Seleccione el tipo de documento" wire:model="TOpIgv"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="Base Imponible" wire:model="BasImp"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="IGV" wire:model="IGV"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="Valor Adq. NG" wire:model="NoGravadas"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="ISC" wire:model="ISC"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="ICBPER" wire:model="ImpBolPla"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="Otros Trib/ Cargos" wire:model="OtroTributo"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="Total CP" wire:model="total"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-datetime-picker class="flex-1 w-full" without-time placeholder="ingresar una fecha valida" id="fecha_emi_mod"
                    label="Fecha Emisión Mod" wire:model="FechaEMod" />
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-select  label="Tipo CP Modificado" :options="$TipoDeDocumentos" option-value="N" option-label="DESCRIPCION"
                    placeholder="Seleccione el tipo de documento" wire:model="TDocEMod" />
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="Serie CP Modificado" wire:model="SerEMod"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="COD. DAM O DSI" wire:model="CodDepenDUAoDSI"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="Nro CP Modificado" wire:model="NumEMod"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-datetime-picker class="flex-1 w-full" without-time placeholder="ingresar una fecha valida" id="fecha_ven"
                    label="FecEmiDetr" wire:model="FecEmiDetr"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-input 
                        label="NumConsDetra" wire:model="NumConstDer"/>
                </div>
                <div class="w-full md:w-2/12 px-2 mb-4">
                    <x-select  label="ClasBienes" :options="$TipoDeClasificacionBienes" option-value="N" option-label="DESCRIPCION"
                    placeholder="Seleccione el tipo de documento" wire:model="ClasBienes"/>
                </div>
            </div>
        @endif
        <div>
        
        </div>
        <div x-data="{ openForm: @entangle('openForm') }">
            <button @click="$wire.set('openForm', !openForm)"
                :class="openForm ? 'bg-yellow-500 text-white' : 'bg-blue-500 text-white'"
                class="px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 mt-4">
                <span x-text="openForm ? 'Ocultar formulario' : 'Agregar Fila'"></span>
            </button>
            <div x-show="openForm" class="mt-5" x-transition>
                @livewire('reusable-form', ['tra' => $tra])
            </div>
        </div>
    </x-card>

    <div  class="mt-5">
        <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-full">
            <div class="p-4 overflow-x-auto">
                <div class="flex gap-3   mb-4">
                    <div>
                        <x-alert title="Debe: {{$de}}" />
                    </div>
                    <div>
                        <x-alert title="Haber: {{$ha}}" secondary/>
                    </div>
                    <div>
                        @if ($to != 0)
                            <x-alert title="Diferencia: {{$to}}" danger />
                        @else
                            <x-alert title="Diferencia: {{$to}}" positive />
                        @endif
                    </div>
                    
                </div>
                
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">CNTA</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DESCRIPCION</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DEBE S/</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">HABER S/</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">DEBE $</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">HABER $</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">GLOSA ESPECIFICA</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">CORRENT</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">RAZ SOCIAL</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">TDOC</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">SER</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NUM</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">M. PAG</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">CC</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ESTADO DOC</th> 
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ESTADO</th>
                            <th class="py-2 px-4 bg-gray-200 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ACCIONES</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @if (!empty($dataAsiento))
                            @foreach ($dataAsiento as $index => $dataItem)
                                <tr>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['Cnta'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['DesCnta'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['DebeS'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['HaberS'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['DebeD'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['HaberD'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['GlosaEspecifica'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['Corrent'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['RazSocial'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['Tdoc'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['Ser'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['Num'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['Mpag'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['CC'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['estado'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center">{{ $dataItem['estado_doc'] ?? '-' }}</td>
                                    <td class="px-2 py-1 border-b text-center flex flex-col gap-3">
                                        <x-button icon="pencil" wire:click="EditarFila({{ $index }})">Editar</x-button>
                                        <x-button negative icon="trash" wire:click="EliminarFila({{ $index }})">Eliminar</x-button>
                                    </td>
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
            <div class="my-4 flex justify-center">
                <x-button teal label="Procesar" wire:click="Procesar"/>
            </div>
        </div>
    </div>




</div>
