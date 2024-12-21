<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use App\Models\Libro;
use App\Models\Mes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ListaAsientos extends Component
{
    public $empresa;
    public $empresaId;
    public $libro;
    public $mes;
    public $lib;
    public $mss;
    public $dataAsiento = [];
    public function mount($id)
    {
        $this->cargardatosGenerales($id);
    }


    public function cargardatosGenerales($id){
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
        $this->libro = Libro::where('id_empresa',$this->empresaId)->get();
        $this->mes = Mes::all();
    }

    public function Procesar()
    {
        if (!$this->lib || !$this->mss) {
            session()->flash('error', 'Debe seleccionar un libro y un mes para procesar.');
            Log::info('Error: No se seleccionó un libro o mes.', [
                'lib' => $this->lib,
                'mss' => $this->mss,
            ]);
            return;
        }
    
        try {
            Log::info('Procesando llamada al procedimiento almacenado.', [
                'mes' => $this->mss,
                'libro' => $this->lib,
                'empresaId' => $this->empresaId,
            ]);
    
            $this->dataAsiento = DB::select('CALL LstaMov(?, ?, ?)', [
                $this->mss,      // Mes seleccionado
                $this->lib,      // Libro seleccionado
                $this->empresaId // ID de la empresa
            ]);
    
            if (empty($this->dataAsiento)) {
                Log::info('El procedimiento no devolvió datos.', [
                    'mes' => $this->mss,
                    'libro' => $this->lib,
                    'empresaId' => $this->empresaId,
                ]);
                session()->flash('error', 'No se encontraron datos para los criterios seleccionados.');
            } else {
                Log::info('Datos devueltos por el procedimiento:', [
                    'data' => $this->dataAsiento,
                ]);
                session()->flash('message', 'Datos procesados exitosamente.');
            }
        } catch (\Exception $e) {
            Log::error('Error al procesar el procedimiento almacenado.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Ocurrió un error al procesar los datos: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.lista-asientos')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
