<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ReportePendientesView extends Component
{
    public $empresa;
    public $empresaId;
    public $cuentaId;
    public $tipoPag = 'Pendientes';
    public $result;

    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
    }

    public function PlanCont($tra){
        $modal['modal'] = True;
        $modal['traspaso'] = $tra;
        $this->dispatch('ModalCuentas', $modal);
    }

    #[On('Cuenta_Pendiente')]
    public function handleReg_Cuenta($traspado){
        $this -> cuentaId = $traspado['CtaCtable'];
    }

    public function Procesar(){
        if(empty($this->cuentaId)){
            session()->flash('error','Selecciona una cuenta');
        }

        $xsql = $this->tipoPag == 'Pendientes'
                ? "CALL Pendientes( '$this->cuentaId','$this->empresaId')"
                : "CALL Pagado('$this->cuentaId','$this->empresaId')";

        $this->result = collect(DB::select($xsql));

        Log::info($this->result);
    }

    public function render()
    {
        return view('livewire.reporte-pendientes-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
