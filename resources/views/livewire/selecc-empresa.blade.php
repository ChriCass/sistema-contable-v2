<div>
    <div class="max-w-screen-xl mx-auto px-4 mt-12">
        <div class="flex flex-wrap justify-center -mx-4">
            <div class="w-full px-4 mb-4">
                <h1 class="text-2xl font-bold text-center">Selecciona a la empresa</h1>
            </div>
            <div class="w-full sm:w-8/12 px-4 mb-4">
                <div class="flex flex-wrap justify-center">
                    @foreach ($empresas as $e)
                    <div class="w-full sm:w-4/12 px-4 mb-6">
                        <!-- Card -->
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                            <img src="https://via.placeholder.com/400x200" alt="Empresa 1" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h2 class="text-xl font-semibold">{{$e->Nombre}}</h2>
                                <p class="mt-2 text-gray-600"><strong>RUC:</strong> {{$e->Ruc}}</p>
                                <p class="mt-2 text-gray-600"><strong>Año: </strong>{{$e->Anno}}</p>
                                <!-- Botón con enlace dinámico -->
                                <a wire:navigate href="{{ route('empresa.dashboard', ['id' => $e->id]) }}" class="mt-4 bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-700 block text-center">
                                    Seleccionar
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
