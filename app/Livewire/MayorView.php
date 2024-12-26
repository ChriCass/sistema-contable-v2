<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use App\Models\Mes;
use App\Exports\MayorhMesExport;
use App\Exports\MayorxMesExport;
use Maatwebsite\Excel\Facades\Excel;
class MayorView extends Component
{
    public $empresa;
    public $empresaId;
    public $mes = '02';
    public $tipoMes = 'x Mes'; 
    public $result;
    public $meses;
    public $showCard = false;
    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
        $this->meses = Mes::all();
    }

    public function procesarDiario()
{
    try {
        $xsql = $this->tipoMes == 'x Mes'
            ? "CALL MayorxMes( '$this->mes','$this->empresaId')"
            : "CALL MayorHastaMes('$this->mes','$this->empresaId')";

        // Ejecutar la consulta
        $this->result = collect(DB::select($xsql));

        // Verificar si el resultado está vacío
        if ($this->result->isEmpty()) {
            // Guardar un mensaje de alerta en la sesión
            session()->flash('alert', 'Mes sin registros.');
            $this->showCard = false;
        } else {
            // Log para ver el resultado completo de la consulta
            Log::info("Resultado del procedimiento almacenado:", ['result' => $this->result]);

            // Guardar un mensaje de éxito en la sesión
            session()->flash('success', 'Los datos se han procesado correctamente.');
            $this->showCard = true;
        }
    } catch (\Exception $e) {
        // Log para capturar el error
        Log::info("Error al ejecutar el procedimiento almacenado: " . $e->getMessage());
        $this->showCard = false;
        // Guardar un mensaje de error en la sesión
        session()->flash('error', 'Ocurrió un error al procesar los datos.');
    }
}

public function deleteResult()
{
    $this->result = null;
    $this->showCard = false;
}

    public function exportarDiario()
    {
        try {
            if ($this->result->isEmpty()) {
                session()->flash('alert', 'No hay datos para exportar.');
                return;
            }

            // Seleccionar el exportador correspondiente
            $exportClass = $this->tipoMes == 'x Mes' ? MayorxMesExport::class : MayorhMesExport::class;

            return Excel::download(new $exportClass($this->result), $this->tipoMes == 'x Mes' ? 'MayorxMes.xlsx' : 'MayorHastaMes.xlsx');
        } catch (\Exception $e) {
            Log::error("Error al exportar el reporte: " . $e->getMessage());
            session()->flash('error', 'Hubo un error al exportar el reporte.');
        }
    }

    public function render()
    {
        return view('livewire.mayor-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
