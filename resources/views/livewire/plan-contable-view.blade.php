<div>
    <x-card>
        <h1 class="font-bold">Plan contable</h1>
    </x-card>
    <!-- Sección de Tabla con Scroll -->
    <x-card class="p-4 w-full overflow-x-auto my-3">
        @if (session()->has('success'))
        <x-alert title="Felicidades!" positive class="mb-3">
            {{ session('success') }}
        </x-alert>
      
        @endif
        <div class="flex gap-3"> <x-button href="{{ route('empresa.plan-contable-gen', ['id' => $empresa->id]) }}"
                wire:navigate positive label="Nuevo" />
            @if (!$haveCuentas)
                <x-button
                    href="{{ route('empresa.importador-general', ['id' => $empresa->id, 'origen' => 'plan_contable']) }}"
                    wire:navigate orange label="Importador masivo" />
            @endif
        </div>
        @livewire('plan-contable-table', ['empresaId' => $empresaId])
    </x-card>
</div>
