<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class DiarioView extends Component
{
    public $empresa;
    public $empresaId;
    public $mes = '02';
    public $tipoMes = 'x Mes'; 
    public $result = [];

    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
    }

    public function procesarDiario()
    {
        try {
            $xsql = $this->tipoMes == 'x Mes'
                ? "CALL LdiarioxMes('$this->mes')"
                : "CALL LdiarioHastaMes('$this->mes')";
    
            // Log para verificar la consulta SQL generada
            Log::info("Ejecutando consulta: $xsql");
    
            // Ejecutar la consulta
            $this->result = DB::select($xsql);
    
            // Log para ver el resultado completo de la consulta
            Log::info("Resultado del procedimiento almacenado:", ['result' => $this->result]);
    
            // Guardar un mensaje de éxito en la sesión
            session()->flash('success', 'Los datos se han procesado correctamente.');
        } catch (\Exception $e) {
            // Log para capturar el error
            Log::info("Error al ejecutar el procedimiento almacenado: " . $e->getMessage());
    
            // Guardar un mensaje de error en la sesión
            session()->flash('error', 'Ocurrió un error al procesar los datos.');
        }
    }

    public function deleteResult()
    {
        $this->result = [];
    }
    public function render()
    {
        
        return view('livewire.diario-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
