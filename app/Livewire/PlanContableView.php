<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use Illuminate\Support\Facades\Log;
use App\Models\PlanContable;
class PlanContableView extends Component
{
    public $empresa;
    public $empresaId;
    public $libro;
    public $mes;
    public $haveCuentas;
    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
        Log::info("empresaId", ['empresa'=> $this->empresaId]);
        $this->dispatch('sending_empresaId', $this->empresaId);
        
            $this->haveCuentas =  $this->checkingCuentas($this->empresaId);
    }

    
    public function checkingCuentas($empresaId)
    {
        $cuentas = PlanContable::where('id_empresas', $empresaId)->exists();
        return $cuentas;
    }

    public function render()
    {
        return view('livewire.plan-contable-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
