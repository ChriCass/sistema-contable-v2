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

                <!-- Primera fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-select :options="$libros" option-value="N" option-label="DESCRIPCION" label="Libro" id="libro" wire:model="dataItem.libro" placeholder="Seleccionar tipo de libro" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-datetime-picker without-time placeholder="Appointment Date" label="Fecha del Documento" id="fecha_doc" wire:model="dataItem.fecha_doc" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-datetime-picker without-time placeholder="Appointment Date" label="Fecha Vec Doc" id="fecha_ven" wire:model="dataItem.fecha_ven" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-datetime-picker without-time placeholder="Appointment Date" label="Fecha de vaucher" id="fecha_vaucher" wire:model="dataItem.fecha_vaucher" required />
                    </div>
                </div>

                <!-- Segunda fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-select :options="$ComprobantesPago" option-value="N" option-label="DESCRIPCION" label="Tipo doc de pago" id="tdoc" wire:model="dataItem.tdoc" placeholder="Seleccionar tipo de documento de pago" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Serie" id="ser" wire:model="dataItem.ser" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Número" id="num" wire:model="dataItem.num" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-select label="Código de Moneda" id="cod_moneda" wire:model="dataItem.cod_moneda" placeholder="Seleccionar moneda" :options="['PEN', 'USD']" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        @livewire('cambio-sunat', ['tipoCambio' => $dataItem['tip_cam'] ?? null])
                    </div>
                </div>

                <!-- Tercera fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-select :options="$opigvs" option-label="Descripcion" option-value="Id" label="Tipo de Op IGV" id="opigv" wire:model="dataItem.opigv" placeholder="Seleccionar tipo op IGV" required />
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
                        <x-input label="No Gravadas" id="no_gravadas" wire:model="dataItem.no_gravadas" class="numeric-input" />
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
                        <x-input label="Glosa" id="glosa" wire:model="dataItem.glosa" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Cuenta 1" id="cnta1" wire:model="dataItem.cnta1.cuenta" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Cuenta 2" id="cnta2" wire:model="dataItem.cnta2.cuenta" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Cuenta 3" id="cnta3" wire:model="dataItem.cnta3.cuenta" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Cuenta Precio" id="cnta_precio" wire:model="dataItem.cnta_precio.cuenta" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Moneda 1" id="mon1" wire:model.live="dataItem.mon1" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Moneda 2" id="mon2" wire:model="dataItem.mon2" />
                    </div>
                </div>

                <!-- Séptima fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Moneda 3" id="mon3" wire:model="dataItem.mon3" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Centro de Costo 1" id="cc1" wire:model="dataItem.cc1" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Centro de Costo 2" id="cc2" wire:model="dataItem.cc2" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Centro de Costo 3" id="cc3" wire:model="dataItem.cc3" />
                    </div>
                </div>

                <!-- Octava fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Cuenta Otro Tributo" id="cta_otro_t" wire:model="dataItem.cta_otro_t.cuenta" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Fecha de Mod" id="fecha_emod" type="date" wire:model="dataItem.fecha_emod" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Tipo Doc Modificado" id="tdoc_emod" wire:model="dataItem.tdoc_emod" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Serie Doc Modificado" id="ser_emod" wire:model="dataItem.ser_emod" />
                    </div>
                </div>

                <!-- Novena fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Número Doc Modificado" id="num_emod" wire:model="dataItem.num_emod" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Fecha Emi Detracción" id="fec_emi_detr" type="date" wire:model="dataItem.fec_emi_detr" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Núm Constancia Detracción" id="num_const_der" wire:model="dataItem.num_const_der" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-select label="Tiene Detracción?" id="tiene_detracc" wire:model="dataItem.tiene_detracc" placeholder="Seleccionar" :options="['Sí', 'No']" required />
                    </div>
                </div>

                <!-- Décima fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Cuenta de Detracción" id="cta_detracc" wire:model="dataItem.cta_detracc.cuenta" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Monto de Detracción" id="mont_detracc" wire:model="dataItem.mont_detracc" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Referencia Interna 1" id="ref_int1" wire:model="dataItem.ref_int1" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Referencia Interna 2" id="ref_int2" wire:model="dataItem.ref_int2" />
                    </div>
                </div>

                <!-- Última fila de inputs -->
                <div class="flex flex-wrap -mx-2">
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-input label="Referencia Interna 3" id="ref_int3" wire:model="dataItem.ref_int3" />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-select :options="$estado_docs" option-value="id" option-label="descripcion" label="Estado Doc" id="estado_doc" wire:model="dataItem.estado_doc" placeholder="Selecciona Estado doc" required />
                    </div>
                    <div class="w-full md:w-3/12 px-2 mb-4">
                        <x-select :options="$estados" option-value="N" option-label="DESCRIPCION" label="Estado" id="estado" wire:model="dataItem.estado" placeholder="Seleccione el estado" required />
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