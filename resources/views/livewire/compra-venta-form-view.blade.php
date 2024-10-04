<div>
    <div class="  flex  flex-wrap">
        <x-button secondary class="mb-3" label="regresar" wire:navigate
            href="{{ route('empresa.compra-venta', ['id' => $empresaId]) }}" />
        <div class="mb-4">
            @livewire('compra-venta-form', ['empresaId' => $empresaId])
        </div>


        <x-card class="w-full">
            @livewire('compra-venta-table')
        </x-card>

    </div>
</div>
