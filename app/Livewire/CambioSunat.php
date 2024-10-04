<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\TipoCambioSunat;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
class CambioSunat extends Component
{   

    public $tipoCambio;
    public $errorMessage;
    public $esDolar;
    public $mostrarContenido = false;
    
    
    #[On('cambioaDolar')]
    public function cambioaDolar($esDolar)
    {
        Log::info("Evento 'cambioaDolar' escuchado. Valor de esDolar: ", ['esDolar' => $esDolar]);
        $this->esDolar = $esDolar;
        $this->consultaApiCambio();
    }

    public function consultaApiCambio()
    {
        $today = now()->toDateString();

        // Verificar si ya existe un registro para el día de hoy
        $existingTipoCambio = TipoCambioSunat::whereDate('Dia', $today)->first();

        if ($existingTipoCambio) {
            $this->tipoCambio = [
                'fecha' => $existingTipoCambio->Dia->toDateString(),
                'precio_compra' => $existingTipoCambio->TipCamCompra,
                'precio_venta' => $existingTipoCambio->TipCamVenta,
            ];
            Log::info("Tipo de cambio del día de hoy obtenido de la base de datos", $this->tipoCambio);
            $this->dispatch('tipoCambioEncontrado', $this->tipoCambio);
            $this->mostrarContenido = true;
        } else {
            try {
                Log::info("Consultando el último tipo de cambio de SUNAT");

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer oxzdu4ZBlghIaetvqYux8CocEVJABQAkptMBcpUyQVhXr5sF3vb0ABZxJF40'
                ])->post('https://api.migo.pe/api/v1/exchange/latest', [
                    'token' => 'oxzdu4ZBlghIaetvqYux8CocEVJABQAkptMBcpUyQVhXr5sF3vb0ABZxJF40'
                ]);

                if ($response->successful()) {
                    // Decodifica el JSON a un array asociativo de PHP
                    $this->tipoCambio = $response->json();
                    $this->dispatch('tipoCambioEncontrado', $this->tipoCambio);
                    Log::info("El array que regresa el tipo de cambio es", $this->tipoCambio);
                    
                    // Guarda los datos en el modelo TipoCambioSunat
                    TipoCambioSunat::create([
                        'Dia' => $this->tipoCambio['fecha'],
                        'TipCamCompra' => $this->tipoCambio['precio_compra'],
                        'TipCamVenta' => $this->tipoCambio['precio_venta'],
                    ]);
                    
                    Log::info("El tipo de cambio ha sido guardado", $this->tipoCambio);
                    $this->mostrarContenido = true;
                } else {
                    $this->consultaBD();
                }
            } catch (\Exception $e) {
                $this->errorMessage = 'Ha ocurrido un error: ' . $e->getMessage();
                Log::error('Error: ' . $e->getMessage());
                $this->consultaBD();
            }
        }
    }

    protected function consultaBD()
    {
        $this->errorMessage = 'Conexión no establecida con la API o datos inválidos. Consultando datos locales.';
        Log::error("Fallo en la conexión con la API. Consultando datos locales.");

        // Consulta el último tipo de cambio ingresado en la base de datos
        $lastTipoCambio = TipoCambioSunat::latest('Dia')->first();

        if ($lastTipoCambio) {
            $this->tipoCambio = [
                'fecha' => $lastTipoCambio->Dia->toDateString(),
                'precio_compra' => $lastTipoCambio->TipCamCompra,
                'precio_venta' => $lastTipoCambio->TipCamVenta,
            ];
            Log::info("Último tipo de cambio obtenido de la base de datos", $this->tipoCambio);
            $this->dispatch('tipoCambioEncontrado', $this->tipoCambio);
            $this->mostrarContenido = true;
        } else {
            $this->errorMessage = 'No hay datos disponibles en la base de datos.';
            Log::error("No se encontraron datos en la base de datos.");
            $this->dispatch('tipoCambioEncontrado', $this->tipoCambio);
        }
    }

    public function render()
    {
        return view('livewire.cambio-sunat');
    }
}
