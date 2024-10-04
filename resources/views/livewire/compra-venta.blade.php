<div>
    <div class="  flex justify-center flex-wrap">
        <x-card class="w-full mb-5 ">
            <h1 class="font-bold">Compra venta</h1>
            <x-button label="Nuevo" wire:navigate href="{{ route('empresa.compra-venta.form', ['id' => $empresaId]) }}" />

        </x-card>
        <div class="w-full"> @livewire('recepctor-excel')</div>
        <div class="w-full"> @livewire('vista-previa-excel')</div>



    </div>
</div>
