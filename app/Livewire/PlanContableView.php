<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use Illuminate\Support\Facades\Log;

class PlanContableView extends Component
{
    public $empresa;
    public $empresaId;
    public $libro;
    public $mes;
    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
        Log::info("empresaId", ['empresa'=> $this->empresaId]);
        $this->dispatch('sending_empresaId', $this->empresaId);

 
    }

    public function render()
    {
        return view('livewire.plan-contable-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
