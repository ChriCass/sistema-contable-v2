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
                <div class="w-full md:w-2/12 px-2">
                    <x-input wire:model="CtaCtable" label="Cuenta contable" />
                    @if (empty($CtaCtable) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-input wire:model="Descripcion" label="Descripción" />
                    @if (empty($Descripcion) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-input wire:model="Nivel" label="Nivel" />
                    @if (empty($Nivel) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-input wire:model="Dest1D" label="Destino 1D" />
                    @if (empty($Dest1D) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-input wire:model="Dest1H" label="Destino 1H" />
                    @if (empty($Dest1H) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-input wire:model="Dest2D" label="Destino 2D" />
                    @if (empty($Dest2D) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-input wire:model="Dest2H" label="Destino 2H" />
                    @if (empty($Dest2H) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-select label="Ajuste 79" wire:model="Ajust79" option-value="id" option-label="descripcion"
                        :options="$SiNo" />
                    @if (empty($Ajust79) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-select label="Esf" wire:model="Esf" option-value="id" option-label="descripcion"
                        :options="$SiNo" />
                    @if (empty($Esf) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-select label="Ern" wire:model="Ern" option-value="id" option-label="descripcion"
                        :options="$SiNo" />
                    @if (empty($Ern) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-select label="Erf" wire:model="Erf" option-value="id" option-label="descripcion"
                        :options="$SiNo" />
                    @if (empty($Erf) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-select label="CC" wire:model="CC" option-value="id" option-label="descripcion"
                        :options="$SiNo" />
                    @if (empty($CC) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
                <div class="w-full md:w-2/12 px-2">
                    <x-input wire:model="Libro" label="Libro" />
                    @if (empty($Libro) && $origen == 'edit')
                        <span class="text-yellow-500 text-xs">No hay datos referido a este campo</span>
                    @endif
                </div>
            </div>
            <div class="flex   -mx-2 mt-4 justify-between">




             
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
