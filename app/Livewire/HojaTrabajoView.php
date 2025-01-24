<?php

namespace App\Livewire;

use App\Models\Libro;
use App\Models\Mes;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;

class HojaTrabajoView extends Component
{
    public $empresa;
    public $empresaId;
    public $años;
    public $mes;
    public $mss;
    public $result;
    public $tipoMes = 'x Mes';
    public $tm;
    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
        $this->mes = Mes::all();
    }

    public function procesar(){
        if (empty($this->mss)){
            session()->flash('error','Selecciona un mes');
        }   
        $xsql = $this->tipoMes == 'x Mes'
                ? "CALL htxmes( '$this->mss','$this->empresaId')"
                : "CALL hthastames('$this->mss','$this->empresaId')";

        $this -> tm = ($this->tipoMes == 'x Mes') ? 1 : 2;        

            // Ejecutar la consulta
        $this->result = collect(DB::select($xsql));
        
            
    }


    public function render()
    {
        return view('livewire.hoja-trabajo-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
