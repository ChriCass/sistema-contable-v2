<div>
    <div  class="  flex justify-center flex-wrap">
        <x-card class="w-full mb-5 ">
            <h1 class="font-bold">Compra venta</h1>
            @livewire('compra-venta-form', ['empresaId' => $empresaId])
        </x-card>        
        <x-card class="w-full">
           @livewire('compra-venta-table')
        </x-card>
         @livewire('recepctor-excel')
         @livewire('vista-previa-excel')
        
    </div>
</div>
