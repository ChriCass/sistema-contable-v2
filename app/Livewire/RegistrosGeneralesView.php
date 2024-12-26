<?php

namespace App\Livewire;

use App\Models\Empresa;
use App\Models\Libro;
use App\Models\Mes;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RegistrosGeneralesView extends Component
{
    public $empresa;
    public $empresaId;
    public $libro;
    public $mes;
    public $mss;
    public $origen;
    public $dataArray;

    public function mount($id)
    {
        $this -> cargarDatos($id);
    }   

    public function cargarDatos($id){
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
        $this->mes = Mes::all();
        $this->origen = request()->get('origen');
        $this->libro = Libro::where('id_empresa',$this->empresaId)
                        ->where('DESCRIPCION',($this->origen == 'ventas') ? 'VENTAS' : 'COMPRAS')
                        ->select('id')
                        ->get();
    }

    public function Procesar(){

        if (!$this->mss) {
            session()->flash('error', 'Debe seleccionar un mes para procesar.');
            return;
        }

        if ($this->origen == 'ventas'){
            $this->dataArray = DB::select('CALL Ventas(?, ?, ?)', [
                $this->libro[0] -> id,      // Libro seleccionado
                $this->mss,      // Mes seleccionado
                $this->empresaId // ID de la empresa
            ]);
        } else {
            $this->dataArray = DB::select('CALL Compras(?, ?, ?)', [
                $this->libro[0] -> id,      // Libro seleccionado
                $this->mss,      // Mes seleccionado
                $this->empresaId // ID de la empresa
            ]);
        }

        Log::info($this->dataArray);
    }

    public function render()
    {
        return view('livewire.registros-generales-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
