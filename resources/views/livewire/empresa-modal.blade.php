<div>
    <x-button label="Crear empresa" wire:click="$set('openModal', true)" primary />

    <x-modal name="persistentModal" wire:model="openModal" persistent>
        <x-card title="Registro de Nueva Empresa">

            <div class="flex flex-wrap justify-center -mx-4">
                @if  (session()->has('error'))
                <x-alert title="¡Ha ocurrido un error!" negative>
                    {{ session('error') }}
                </x-alert>
            @endif
            

                <div class="w-full sm:w-12/12 px-4 mb-3">
                    <x-input label="Razon Social" wire:model='nombre' placeholder="nombre de la empresa" />
                    @error('nombre')
                    @enderror
                </div>

                <div class="w-full sm:w-12/12 px-4 mb-3">
                    <x-select label="Seleccione año" placeholder="Selec." :options="$anios"
                        wire:model.live="anio" />
                    @error('anio')
                    @enderror
                </div>

         
                <div class="w-full  px-4">
                    <x-maskable mask="##############" wire:model='ruc' label="RUC" placeholder="" />
                    @error('ruc')
                    @enderror
                </div>


                <x-slot name="footer" class="flex justify-end gap-x-4">
                    <x-button flat label="Cancelar" wire:click="$set('openModal', false)" />
                    <x-button primary label="Aceptar" wire:click='createEmpresa' />
                </x-slot>
            </div>
        </x-card>
    </x-modal>
</div>
