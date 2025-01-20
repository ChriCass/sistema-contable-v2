<?php

namespace App\Livewire;
use App\Models\Empresa;
use Livewire\Component;
use App\Models\PlanContable;
class ImportadorGeneral extends Component
{
    public $origen;
    public $empresa;
    public $empresaId;

    public function mount($id)
    {
        $this->origen = request()->get('origen', 'ingreso');
        if ($this->origen == 'plan_contable') {
          $this->haveCuentas =  $this->checkingCuentas($this->empresaId);
        }
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
       
    }

    public function checkingCuentas($empresaId)
    {
        $cuentas = PlanContable::where('id_empresas', $empresaId)->exists();
        return $cuentas;
    }
    public function render()
    {
        return view('livewire.importador-general')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
