<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ReporteDetalleView extends Component
{
    public $empresa;
    public $empresaId;
    public $Cuenta;
    public $Correntista;
    public $TipDoc;
    public $Serie;
    public $Numero;
    public $result;

    public function mount($id)
    {
        $this -> CargarDatos($id);
        if (is_null($this->Cuenta) || is_null($this->Correntista) || is_null($this->TipDoc) || is_null($this->Serie) || is_null($this->Numero)) {
            $this->result = null;
        }else{
            $xsql = "Call Detalle('$this->Cuenta','$this->Correntista','$this->TipDoc','$this->Serie','$this->Numero','$this->empresaId')";
            $this->result = collect(DB::select($xsql));
        }
        
    }

    public function CargarDatos($id){
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
        $this->Cuenta = request()->get('cuenta');
        $this->Correntista = request()->get('correntista');
        $this->TipDoc = request()->get('tdoc');
        $this->Serie = request()->get('serie');
        $this->Numero = request()->get('numero');
    }

    public function datos(){

    }

    public function render()
    {
        return view('livewire.reporte-detalle-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
