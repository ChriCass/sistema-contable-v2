<div>

    <div class="mb-3">
        <x-label for="tip_cam" value="Tipo de Cambio de hoy" class="font-bold" />
        <div class="flex flex-col items-center justify-center border rounded p-4">
            @if ($tipoCambio)
                <p class="my-3 text-lg font-bold">{{ $tipoCambio['precio_venta'] }}</p>
            @else
                <p class="my-3">Aquí aparecerá el tipo de cambio</p>
            @endif
        </div>
 
        <x-button 
            primary 
            label="Consultar tipo de cambio" 
            wire:click="consultaApiCambio" 
            class="mt-3"
        />

        @if ($errorMessage)
            <x-alert title="Error" negative padding="small" class="mt-3">
                <x-slot name="slot">
                    {{ $errorMessage }}
                </x-slot>
            </x-alert>
        @endif
    </div>

</div>
