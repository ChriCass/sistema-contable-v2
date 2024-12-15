<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\Correntista;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Session;

class CorrentistaInput extends Component
{
    public $data;
    public $tdoc;
    public $correntista;
    public $errorMessage;
    public $responseData;
    public $flashMessage;
    public $isFromDatabase = false; // Nueva propiedad
    public $isEditMode = false;

    public function mount($correntista = null, $isEditMode = false)
    {
        $this -> verificarDatos($correntista,$isEditMode);
    }
    
    public function verificarDatos($correntista,$isEditMode){
        if ($correntista) {
            if (isset($correntista['ruc_emisor'])) {
                $this->tdoc = 'RUC';
                $this->correntista = $correntista['ruc_emisor'];
                $this->isFromDatabase = true;
            } elseif (isset($correntista['ruc'])) {
                $this->tdoc = 'RUC';
                $this->correntista = $correntista['ruc'];
            } elseif (isset($correntista['dni'])) {
                $this->tdoc = 'DNI';
                $this->correntista = $correntista['dni'];
            }
            $this->responseData = $correntista;
        }
        $this->isEditMode = $isEditMode;
    }

    #[On('PasaCorrent')]
    public function handlePasaCorrent($correntistaData){
        $this -> verificarDatos($correntistaData,true);
    }


    #[On('resetCorrentistaInput')]
    public function resetFields()
    {
        $this->tdoc = null;
        $this->correntista = null;
        $this->errorMessage = null;
        $this->responseData = null;
        $this->flashMessage = null;
        $this->isFromDatabase = false;
    }

    public function consultarCorrentista()
    {
        $this->reset('errorMessage', 'responseData', 'flashMessage', 'isFromDatabase');

        $this->validate([
            'tdoc' => 'required',
            'correntista' => 'required',
        ]);

        // Log para la consulta a la base de datos
        Log::info("Consultando la base de datos para el correntista: {$this->correntista}");

        // Buscar por ruc_emisor en lugar de nombre_o_razon_social
        $correntistaConsulta = Correntista::where('ruc_emisor', $this->correntista)->first();

        if ($correntistaConsulta) {
            Log::info("Correntista encontrado en la base de datos: ", $correntistaConsulta->toArray());
            $this->responseData = $correntistaConsulta;
            $this->isFromDatabase = true; // Indica que los datos provienen de la base de datos
            $this->flashMessage = 'El correntista ya estaba registrado en la base de datos.';
            $this->dispatch('correntistaEncontrado', $this->responseData);
        } else {
            Log::info("Correntista no encontrado en la base de datos, procediendo a consultar la API");

            if ($this->tdoc == 'RUC') {
                $this->consultarRUC();
            } elseif ($this->tdoc == 'DNI') {
                $this->consultarDNI();
            } else {
                $this->errorMessage = 'Tipo de Documento no válido';
            }
        }
    }

    private function consultarRUC()
    {
        if (strlen($this->correntista) != 11) {
            $this->errorMessage = 'Digite un Número de RUC válido';
            return;
        }

        $ruc = $this->correntista;

        try {
            Log::info("Consultando RUC en la API para el RUC: {$ruc}");

            $response = Http::withHeaders([
                'Authorization' => 'Bearer oxzdu4ZBlghIaetvqYux8CocEVJABQAkptMBcpUyQVhXr5sF3vb0ABZxJF40'
            ])->post('https://api.migo.pe/api/v1/ruc', [
                'ruc' => $ruc,
                'token' => 'oxzdu4ZBlghIaetvqYux8CocEVJABQAkptMBcpUyQVhXr5sF3vb0ABZxJF40'
            ]);

            if ($response->successful()) {
                Log::info("Respuesta exitosa de la API para el RUC: ", $response->json());
                $this->responseData = $response->json();

                // Guardar en la base de datos usando create()
                $this->guardarCorrentista($this->responseData, 'RUC');

                $this->dispatch('correntistaEncontrado', $this->responseData);
            } else {
                $this->errorMessage = 'Conexión no establecida con la API';
                Log::error("Fallo en la conexión con la API para el RUC: {$ruc}");
            }
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al conectar con la API: ' . $e->getMessage();
            Log::error("Error al conectar con la API para el RUC: {$ruc} - Error: " . $e->getMessage());
        }
    }

    private function consultarDNI()
    {
        if (strlen($this->correntista) != 8) {
            $this->errorMessage = 'Digite un Número de DNI válido';
            return;
        }

        $dni = $this->correntista;

        try {
            Log::info("Consultando DNI en la API para el DNI: {$dni}");

            $response = Http::withHeaders([
                'Authorization' => 'Bearer oxzdu4ZBlghIaetvqYux8CocEVJABQAkptMBcpUyQVhXr5vb0ABZxJF40'
            ])->post('https://api.migo.pe/api/v1/dni', [
                'dni' => $dni,
                'token' => 'oxzdu4ZBlghIaetvqYux8CocEVJABQAkptMBcpUyQVhXr5sF3vb0ABZxJF40'
            ]);

            if ($response->successful()) {
                Log::info("Respuesta exitosa de la API para el DNI: ", $response->json());
                $this->responseData = $response->json();

                // Guardar en la base de datos usando create()
                $this->guardarCorrentista($this->responseData, 'DNI');

                $this->dispatch('correntistaEncontrado', $this->responseData);
            } else {
                $this->errorMessage = 'Conexión no establecida con la API';
                Log::error("Fallo en la conexión con la API para el DNI: {$dni}");
            }
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al conectar con la API: ' . $e->getMessage();
            Log::error("Error al conectar con la API para el DNI: {$dni} - Error: " . $e->getMessage());
        }
    }

    private function guardarCorrentista($data, $tipoDocumento)
    {
        try {
            // Verificar si el correntista ya existe en la base de datos
            $correntistaExistente = Correntista::where('ruc_emisor', $data['ruc'] ?? $data['dni'])->first();
    
            if ($correntistaExistente) {
                // Si el correntista ya existe, simplemente retornamos un mensaje sin hacer nada
                $this->flashMessage = 'El correntista ya está registrado en la base de datos.';
                Log::info("Correntista ya existente en la base de datos, no se realizaron cambios.", ['correntista' => $correntistaExistente]);
                return;
            }
    
            $empresaId = Session::get('EmpresaId');
            
            // Si no existe, lo creamos
            Correntista::create([
                'id_empresas' => $empresaId['id'],
                'ruc_emisor' => $data['ruc'] ?? $data['dni'],
                'nombre_o_razon_social' => $data['nombre_o_razon_social'] ?? $data['nombre'] ?? 'Nombre no disponible',
                'estado_del_contribuyente' => $data['estado_del_contribuyente'] ?? null,
                'condicion_de_domicilio' => $data['condicion_de_domicilio'] ?? null,
                'ubigeo' => $data['ubigeo'] ?? null,
                'tipo_de_via' => $data['tipo_de_via'] ?? null,
                'nombre_de_via' => $data['nombre_de_via'] ?? null,
                'codigo_de_zona' => $data['codigo_de_zona'] ?? null,
                'tipo_de_zona' => $data['tipo_de_zona'] ?? null,
                'numero' => $data['numero'] ?? null,
                'interior' => $data['interior'] ?? null,
                'lote' => $data['lote'] ?? null,
                'dpto' => $data['dpto'] ?? null,
                'manzana' => $data['manzana'] ?? null,
                'kilometro' => $data['kilometro'] ?? null,
                'distrito' => $data['distrito'] ?? null,
                'provincia' => $data['provincia'] ?? null,
                'departamento' => $data['departamento'] ?? null,
                'direccion_simple' => $data['direccion_simple'] ?? null,
                'direccion' => $data['direccion'] ?? null,
                'idt02doc' => $tipoDocumento === 'RUC' ? 6 : 1,  // 6 para RUC, 1 para DNI
            ]);
    
            $this->flashMessage = 'El correntista se ha guardado en la base de datos.';
            Log::info("Correntista guardado en la base de datos.");
    
            // Despachar el evento para notificar que el correntista ha sido creado
            $this->dispatch('correntistaActualizado', $data);
    
        } catch (\Exception $e) {
            $this->errorMessage = 'Error al guardar el correntista en la base de datos.';
            Log::error("Error al guardar el correntista en la base de datos: " . $e->getMessage());
        }
    }
    
    public function editarCorrentista()
    {
        // Resetear mensajes de error y flash
        $this->reset('errorMessage', 'flashMessage');
    
        // Verificar el tipo de documento y llamar a la función correspondiente
        if ($this->tdoc === 'RUC') {
            $this->consultarRUC();
        } elseif ($this->tdoc === 'DNI') {
            $this->consultarDNI();
        } else {
            $this->errorMessage = 'Tipo de Documento no válido';
            Log::error('Tipo de documento no válido durante la edición del correntista.');
            return;
        }
    
        // Si no hay errores, despachar el evento con los datos actualizados
        if (!$this->errorMessage) {
            $this->dispatch('correntistaActualizado', $this->responseData);
            Log::info('Correntista actualizado enviado al EditCompraVentaForm.', ['correntista' => $this->responseData]);
        }
    }
    

    public function render()
    {
        return view('livewire.correntista-input');
    }
}
