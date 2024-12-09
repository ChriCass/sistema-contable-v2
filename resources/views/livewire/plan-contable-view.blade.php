<div>
    <x-card>
        <h1 class="font-bold">Plan contable</h1>
    </x-card>
        <!-- Sección de Tabla con Scroll -->
        <x-card class="p-4 w-full overflow-x-auto my-3">
            @livewire('plan-contable-table', ['empresaId' => $empresaId])
        </x-card>
      
      
 

  




</div>
