<div>
    <x-card class="w-full mb-5 ">
        <h1 class="font-bold">Formulario de Cuenta contable</h1>
    </x-card>
    <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-full">
        <x-card>
            @if (session()->has('error'))
                <x-alert title="Error!" negative class="mb-3">
                    {{ session('error') }}
                </x-alert>
            @elseif (session()->has('warning'))
                <x-alert title="Advertencia!" warning class="mb-3">
                    {{ session('warning') }}
                </x-alert>
            @endif
            <x-button class="mb-5 mt-3" href="{{ route('empresa.plan-contable', ['id' => $empresa->id]) }}" wire:navigate
                secondary label="Atras" />
            <div class="flex flex-wrap">
                <div class="w-full">
                    <h4 class="font-bold mb-3 mt-5">Nombre de cuenta</h4>
                </div>
                <div class="w-full md:w-4/12 px-2">
                    <x-maskable mask="###############" wire:model="CtaCtable" label="Cuenta contable" />
                    @error('CtaCtable')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                    @if (empty($CtaCtable) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-4/12 px-2">
                    <x-input  wire:model="Descripcion" label="Descripción" />
                    @error('Descripcion')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                    @if (empty($Descripcion) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-4/12 px-2 mb-4">
                    <x-maskable  mask="#####" wire:model="Nivel" label="Nivel" />
                    @error('Nivel')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    @if (empty($Nivel) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full">
                    <h4 class="font-bold mb-3 mt-5">Destinos</h4>
                </div>
                <div class="w-full md:w-3/12 px-2">
                    <x-maskable mask="###############" wire:model="Dest1D" label="Destino 1D" />
                    @error('Dest1D')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                    @if (empty($Dest1D) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-3/12 px-2">
                    <x-maskable mask="###############" wire:model="Dest1H" label="Destino 1H" />
                    @error('Dest1H')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    @if (empty($Dest1H) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-3/12 px-2">
                    <x-maskable mask="###############" wire:model="Dest2D" label="Destino 2D" />
                    @error('Dest2D')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                    @if (empty($Dest2D) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-3/12 px-2 mb-4">
                    <x-maskable mask="###############" wire:model="Dest2H" label="Destino 2H" />
                    @error('Dest2H')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                    @if (empty($Dest2H) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full">
                    <h4 class="font-bold mb-3 mt-5">Configuracion hoja de trabajo</h4>
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-select label="Ajuste 79" wire:model="Ajust79" option-value="id" option-label="descripcion"
                        :options="$SiNo" />
                        @error('Ajust79')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    @if (empty($Ajust79) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-select label="Esf" wire:model="Esf" option-value="id" option-label="descripcion"
                        :options="$SiNo" />
                        @error('Esf')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    @if (empty($Esf) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-select label="Ern" wire:model="Ern" option-value="id" option-label="descripcion"
                        :options="$SiNo" />
                        @error('Ern')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    @if (empty($Ern) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-select label="Erf" wire:model="Erf" option-value="id" option-label="descripcion"
                        :options="$SiNo" />
                        @error('Erf')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    @if (empty($Erf) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-select label="CC" wire:model="CC" option-value="id" option-label="descripcion"
                        :options="$SiNo" />
                        @error('CC')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                    @if (empty($CC) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-input wire:model="Libro" label="Libro" />
                    @error('Libro')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
                    @if (empty($Libro) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
            </div>
            <div class="flex  mt-5 -mx-2 justify-between">




             
                <div class="flex items-center mt-4 space-x-2">
                    <div>
                        @if ($origen === 'edit')
                            <x-button label="Editar" wire:click='UpdatePlanContable({{ $CtaCtableEdit }})' warning />
                        @else
                            <x-button label="Aceptar" wire:click='CreatePlanContable' primary />
                        @endif
                    </div>
                </div>
            </div>
    </div>
</div>




</x-card>
</div>

</div>
