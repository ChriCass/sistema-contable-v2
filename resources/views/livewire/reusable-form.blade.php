<div>
    <form wire:submit.prevent="submit">
        @csrf



        @if (session()->has('error'))
            <x-alert title="Error!" negative class="mb-3">
                {{ session('error') }}
            </x-alert>
        @endif

        <!-- Primera fila de inputs -->
        <div class="flex flex-wrap -mx-2">
            <div class="w-full">
                <h4 class="font-bold mb-3">Datos</h4>
            </div>
            <div class="w-full  px-2 mb-4">
                @livewire('correntista-input')
            </div>
            <div class="w-full md:w-6/12 px-2 mb-4">
                <x-input description="ingrese el id de la cuenta a asignar"   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').slice(0, 10)" 
                    label="Cuenta" 
                    wire:model.live="cuentaId"  
                    placeholder="Buscar cuenta" 
                    style="margin-right: 3rem">
                    
                    <x-slot name="prepend">
                        <div class="absolute inset-y-0 right-0">
                   
                            <x-button class="h-full" icon="magnifying-glass-circle" primary wire:click="buscarCuenta" />
                        </div>
                    </x-slot>
                </x-input>
            </div>
            
            <div class="w-full md:w-6/12 px-2 mb-4">
                <x-input 
                    label="Descripción de cuenta" 
                    wire:model.live="descripcionCuenta"   
                    readonly />
            </div>
            

            <div class="w-full md:w-3/12 px-2 mb-4">
                <x-input  prefix="s/." label="Debe" placeholder="Debe en soles" />
            </div>

            <div class="w-full md:w-3/12 px-2 mb-4">
                <x-input prefix="s/."  label="Haber" placeholder="Haber en soles" />
            </div>


            <div class="w-full md:w-3/12 px-2 mb-4">
                <x-input prefix="$"  label="Debe" placeholder="Debe en Dolares" />
            </div>

            <div class="w-full md:w-3/12 px-2 mb-4">
                <x-input prefix="$" label="Haber" placeholder="Haber en Dolares" />
            </div>
            <div class="w-full md:w-6/12 px-2 mb-4">
             @livewire('cambio-sunat')
            </div>
            <div class="w-full md:w-6/12 px-2 mb-4">
                <x-input   label="Glosa especifica" placeholder="glosa" />
            </div>

        </div>

        <div class="flex flex-wrap mt-3">
            <div class="w-full">
                <h4 class="font-bold mb-3">Tipo de pago</h4>
            </div>
            <div class="w-full px-2 mb-4">
                <x-select label="Tipo de medio de pago" placeholder="Selecc." :options="$tipoPagos" option-label="DESCRIPCION" option-value="N" />
            </div>



        </div>

        <div class="flex flex-wrap mt-3">
            <div class="w-full">
                <h4 class="font-bold mb-3">Centro de Costos</h4>
            </div>
            <div class="w-full md:w-6/12 px-2 mb-4">
                <x-select label="Centro de costos"  :options="$CentrodeCostos"  option-label="Descripcion" option-value="id_cc" />
            </div>

            <div class="w-full md:w-6/12 px-2 mb-4">
                <x-select :options="$estado_docs" option-value="id" option-label="descripcion" label="Estado Doc"
                id="estado_doc" wire:model="estado_doc" placeholder="Selecciona Estado doc" required />
            </div>

        </div>
        <div class="flex flex-wrap mt-3">
            <div class="w-full">
                <h4 class="font-bold mb-3">Adicionales</h4>
            </div>

            <div class="w-full md:w-6/12 px-2 mb-4">
                <x-select :options="$estados" option-value="N" option-label="DESCRIPCION" label="Estado"
                id="estado" wire:model="estado" placeholder="Seleccione el estado" required />
            </div>
            <div class="w-full md:w-4/12 px-2 mb-4">
                <x-input label="orden"  option-label="name" option-value="id" />
            </div>

        </div>


        <!-- Botón de Envío -->
        <div class="flex justify-center mt-6">
            <x-button type="submit" label="Agregar a lista" primary />
        </div>
    </form>
</div>
