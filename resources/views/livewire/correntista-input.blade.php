<div>
    <div class="mb-3">
        <x-native-select
            label="Tipo de Documento"
            wire:model="tdoc"
            id="tdoc"
        >
            <option value="">Seleccione</option>
            <option value="RUC" {{ $tdoc === 'RUC' ? 'selected' : '' }}>RUC</option>
            <option value="DNI" {{ $tdoc === 'DNI' ? 'selected' : '' }}>DNI</option>
        </x-native-select>
    </div>

    <div class="mb-3">
        <x-input
            label="Número"
            wire:model="correntista"
            type="text"
            id="correntista"
            placeholder="Ingrese el número"
            value="{{ $responseData[$tdoc == 'RUC' ? 'ruc' : 'dni'] ?? '' }}"
        />
    </div>

    @if($isEditMode)
        <x-button
            wire:click="editarCorrentista"
            info
            label="Editar Correntista"
            class="mt-3"
        />
    @else
        <x-button
            wire:click="consultarCorrentista"
            primary
            label="Consultar"
            class="mt-3"
        />
    @endif

    @if($errorMessage)
        <x-alert title="Error!" negative padding="small">
            <x-slot name="slot">
                {{ $errorMessage }}
            </x-slot>
        </x-alert>
    @endif

    @if($responseData)
        <x-alert title="Encontrado!" positive padding="none">
            <x-slot name="slot">
                {{-- Mostrar el nombre según la fuente de los datos --}}
                {{ $responseData['nombre_o_razon_social'] ?? $responseData['nombre'] ?? 'Nombre no encontrado' }}

                @if($flashMessage)
                    <div class="mt-2 text-sm text-teal-600">
                        {{ $flashMessage }}
                    </div>
                @endif
            </x-slot>
        </x-alert>
    @endif
</div>
