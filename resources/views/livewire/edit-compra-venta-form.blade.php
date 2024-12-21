<div>
    <x-button icon="pencil" label="Editar" class="px-6" wire:click="$set('openModal', true)" warning />

    <x-modal name="persistentModal" wire:model="openModal">
        <x-card title="Compra Venta Formulario">
            <form wire:submit.prevent="submit">
                @csrf
                
                <!-- Primer Bloque: Correntista -->
                <div class="flex flex-col mb-5">
                    @livewire('correntista-input', ['correntista' => $dataItem['correntistaData'] ?? null, 'isEditMode' => true])
                </div>
                @if (session()->has('error'))
                    <x-alert title="Error!" negative class="mb-3">
                        {{ session('error') }}
                    </x-alert>
                @endif
                <!-- Primera fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-select :options="$libros" option-value="N" option-label="DESCRIPCION" label="Libro" id="libro" wire:model.live="dataItem.libro" placeholder="Seleccionar tipo de libro" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-datetime-picker without-time placeholder="Appointment Date" label="Fecha del Documento" id="fecha_doc" wire:model.live="dataItem.fecha_doc" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-datetime-picker without-time placeholder="Appointment Date" label="Fecha Vec Doc" id="fecha_ven" wire:model.live="dataItem.fecha_ven" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-datetime-picker without-time placeholder="Appointment Date" label="Fecha de vaucher" id="fecha_vaucher" wire:model.live="dataItem.fecha_vaucher" required />
                    </div>
                </div>

                <!-- Segunda fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-select :options="$ComprobantesPago" option-value="N" option-label="DESCRIPCION" label="Tipo doc de pago" id="tdoc" wire:model.live="dataItem.tdoc" placeholder="Seleccionar tipo de documento de pago" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Serie" id="ser" wire:model.live="dataItem.ser" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Número" id="num" wire:model.live="dataItem.num" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-select label="Código de Moneda" id="cod_moneda" wire:model.live="dataItem.cod_moneda" placeholder="Seleccionar moneda" :options="['PEN', 'USD']" required />
                    </div>
                 
                </div>

                <!-- Tercera fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-select :options="$opigvs" option-label="Descripcion" option-value="Id" label="Tipo de Op IGV" id="opigv" wire:model.live="dataItem.opigv" placeholder="Seleccionar tipo op IGV" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-select label="Porcentaje Base Imp" id="bas_imp_percentage" wire:model.live="dataItem.porcentaje" placeholder="Seleccionar porcentaje" :options="['10%', '18%']" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Base Imponible" id="bas_imp" wire:model.live="dataItem.bas_imp" class="numeric-input" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="IGV" id="igv" wire:model.live="dataItem.igv" class="numeric-input" />
                    </div>
                </div>

                <!-- Cuarta fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="No Gravadas" id="no_gravadas" wire:model.live="dataItem.no_gravadas" class="numeric-input" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="ISC" id="isc" wire:model.live="dataItem.isc" class="numeric-input" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Importe Bol. Pla." id="imp_bol_pla" wire:model.live="dataItem.imp_bol_pla" class="numeric-input" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Otro Tributo" id="otro_tributo" wire:model.live="dataItem.otro_tributo" class="numeric-input" />
                    </div>
                </div>

                <!-- Quinta fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Precio" id="precio" wire:model.live="dataItem.precio" readonly />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Glosa" id="glosa" wire:model.live="dataItem.glosa" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Cuenta 1" id="cnta1" wire:model.live="dataItem.cnta1.cuenta" wire:keydown.f2="modal(7)" required/>
                        @livewire('cuadro-de-cuentas')
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Cuenta 2" id="cnta2" wire:model.live="dataItem.cnta2.cuenta" wire:keydown.f2="modal(8)" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Cuenta 3" id="cnta3" wire:model.live="dataItem.cnta3.cuenta" wire:keydown.f2="modal(9)"/>
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Cuenta Precio" id="cnta_precio" wire:model.live="dataItem.cnta_precio.cuenta" wire:keydown.f2="modal(10)"/>
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Moneda 1" id="mon1" wire:model.live="dataItem.mon1" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Moneda 2" id="mon2" wire:model.live="dataItem.mon2" />
                    </div>
                </div>

                <!-- Séptima fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Moneda 3" id="mon3" wire:model.live="dataItem.mon3" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Centro de Costo 1" id="cc1" wire:model.live="dataItem.cc1" wire:keydown.f2="modalCentroCostos(4)"/>
                        @livewire('modal-centro-de-costos')
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Centro de Costo 2" id="cc2" wire:model.live="dataItem.cc2" wire:keydown.f2="modalCentroCostos(5)"/>
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Centro de Costo 3" id="cc3" wire:model.live="dataItem.cc3" wire:keydown.f2="modalCentroCostos(6)"/>
                    </div>
                </div>

                <!-- Octava fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Cuenta Otro Tributo" id="cta_otro_t" wire:model.live="dataItem.cta_otro_t.cuenta" wire:keydown.f2="modal(11)" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Fecha de Mod" id="fecha_emod" type="date" wire:model.live="dataItem.fecha_emod" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Tipo Doc Modificado" id="tdoc_emod" wire:model.live="dataItem.tdoc_emod" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Serie Doc Modificado" id="ser_emod" wire:model.live="dataItem.ser_emod" />
                    </div>
                </div>

                <!-- Novena fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Número Doc Modificado" id="num_emod" wire:model.live="dataItem.num_emod" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Fecha Emi Detracción" id="fec_emi_detr" type="date" wire:model.live="dataItem.fec_emi_detr" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Núm Constancia Detracción" id="num_const_der" wire:model.live="dataItem.num_const_der" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-select label="Tiene Detracción?" id="tiene_detracc" wire:model.live="dataItem.tiene_detracc" placeholder="Seleccionar" :options="['Sí', 'No']" required />
                    </div>
                </div>

                <!-- Décima fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Cuenta de Detracción" id="cta_detracc" wire:model.live="dataItem.cta_detracc.cuenta" wire:keydown.f2="modal(12)" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Monto de Detracción" id="mont_detracc" wire:model.live="dataItem.mont_detracc" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Referencia Interna 1" id="ref_int1" wire:model.live="dataItem.ref_int1" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Referencia Interna 2" id="ref_int2" wire:model.live="dataItem.ref_int2" />
                    </div>
                </div>

                <!-- Última fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Referencia Interna 3" id="ref_int3" wire:model.live="dataItem.ref_int3" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-select :options="$estado_docs" option-value="id" option-label="descripcion" label="Estado Doc" id="estado_doc" wire:model.live="dataItem.estado_doc" placeholder="Selecciona Estado doc" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-select :options="$estados" option-value="N" option-label="DESCRIPCION" label="Estado" id="estado" wire:model.live="dataItem.estado" placeholder="Seleccione el estado" required />
                    </div>
                </div>

                <!-- Botón de Envío -->
                <div class="flex justify-center mt-6">
                    <x-button  wire:click='guardarCambios' label="Agregar a lista" primary />
                </div>
            </form>
        </x-card>
    </x-modal>
</div>
