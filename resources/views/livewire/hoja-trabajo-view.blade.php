<div>
    <x-card>
        <h1 class="font-bold">hoja de trabajo</h1>
    </x-card>


    <x-card class="p-4 w-full mt-5">
        <div class="flex flex-wrap justify-center gap-2">

            <div class="w-full md:w-3/12">

                <div class="text-sm font-bold flex flex-col items-start space-y-4">
                    <x-select label="Mes" class="w-full" :options="$mes" option-value="N" option-label="MES"
                        id="mes" wire:model="mes" placeholder="Meses" />
                    <x-select label="Año" placeholder="Selecc." :options="$años" wire:model="año" />
                </div>
            </div>




            <div class="w-full flex flex-col items-center mt-4 ">
                <button wire:click="procesarReporte"
                    class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-8 rounded-full shadow-lg transform hover:scale-105 transition-transform duration-300 ease-in-out flex items-center space-x-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                        <path
                            d="M20 8l-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM9 19H7v-9h2v9zm4 0h-2v-6h2v6zm4 0h-2v-3h2v3zM14 9h-1V4l5 5h-4z">
                        </path>
                    </svg>
                    <span>Procesar</span>
                </button>
            </div>



        </div>
    </x-card>

    <div class="mt-5">
        <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-full">
            @if (session()->has('message'))
            <x-alert title="¡Éxito!" positive class="mb-3">
                {{ session('message') }}
            </x-alert>
        @endif

        @if (session()->has('error'))
            <x-alert title="¡Error!" negative>
                <x-slot name="slot" class="italic mb-5">
                    {{ session('error') }}
                </x-slot>
            </x-alert>
        @endif

        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border-b">TIPO DE CUENTA</th>
                    <th class="px-4 py-2 border-b">CUENTA</th>
                    <th class="px-4 py-2 border-b">DEBE</th>
                    <th class="px-4 py-2 border-b">HABER</th>
                    <th class="px-4 py-2 border-b">SUM DEBE</th>
                    <th class="px-4 py-2 border-b">SUM HABER</th>
                    <th class="px-4 py-2 border-b">ACCION</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 py-2 border-b">Tipo de Cuenta 1</td>
                    <td class="px-4 py-2 border-b">Cuenta 1</td>
                    <td class="px-4 py-2 border-b">Debe 1</td>
                    <td class="px-4 py-2 border-b">Haber 1</td>
                    <td class="px-4 py-2 border-b">Sum Debe 1</td>
                    <td class="px-4 py-2 border-b">Sum Haber 1</td>
                    <td class="px-4 py-2 border-b">
                        <x-button wire:navigate
                            href="{{ route('empresa.hoja-trabajo-analisis', ['tipoDeCuenta' => 'cxp', 'id' => $empresa->id]) }}"
                            label="Analizar" primary />
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2 border-b">Tipo de Cuenta 2</td>
                    <td class="px-4 py-2 border-b">Cuenta 2</td>
                    <td class="px-4 py-2 border-b">Debe 2</td>
                    <td class="px-4 py-2 border-b">Haber 2</td>
                    <td class="px-4 py-2 border-b">Sum Debe 2</td>
                    <td class="px-4 py-2 border-b">Sum Haber 2</td>
                    <td class="px-4 py-2 border-b">       <x-button wire:navigate
                        href="{{ route('empresa.hoja-trabajo-analisis', ['tipoDeCuenta' => 'cxp', 'id' => $empresa->id]) }}"
                        label="Analizar" primary /></td>
                </tr>
                <!-- Agrega más filas según sea necesario -->
            </tbody>
        </table>
    </div>
</div>
</div>
