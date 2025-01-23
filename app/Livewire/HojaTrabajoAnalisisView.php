<?php

namespace App\Livewire;

use App\Models\Empresa;
use App\Models\Mes;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class HojaTrabajoAnalisisView extends Component
{   
    public $empresa;
    public $empresaId;
    public $años;
    public $mes;
    public $tipoDeCuenta;
    public $cuenta;
    public $tipoMes;
    public $result;


    public function mount($id,$tipoDeCuenta)
    {
        $this->cargarDatosGenerales($id,$tipoDeCuenta);
        $this->Datos();
    }

    public function cargarDatosGenerales($id,$tipoDeCuenta){
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
        $this->tipoDeCuenta = $tipoDeCuenta;
        $this->cuenta = request()->get('cuenta');
        $this->mes = request()->get('mes');
        $this->tipoMes = request()->get('tipoMes');

    }

    public function Datos(){
        if ($this->tipoDeCuenta == 'ANA') {
            $procedure = ($this->tipoDeCuenta == 1) ? 'AnalisisxMes' : 'AnalisisHastaMes';
        } else {
            $procedure = ($this->tipoDeCuenta == 1) ? 'diarioxCuentaxmes' : 'diarioxCuentaHastames';
        }
        
        $xsql = "CALL $procedure('$this->mes', '$this->cuenta', '$this->empresaId')";
        
        $this->result = collect(DB::select($xsql));

    }

    public function render()
    {
        return view('livewire.hoja-trabajo-analisis-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
