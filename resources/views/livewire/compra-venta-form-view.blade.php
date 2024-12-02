<div>
    <div class="flex flex-col">
        <x-button secondary class="px-4 py-2 mb-3 text-sm" label="regresar" wire:navigate
            href="{{ route('empresa.compra-venta', ['id' => $empresaId]) }}" />
        <div class="mb-4">
            @livewire('compra-venta-form', ['empresaId' => $empresaId])
        </div>


        <x-card class="w-full">
            @livewire('compra-venta-table')
        </x-card>

    </div>
</div>
