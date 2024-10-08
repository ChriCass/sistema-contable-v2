<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use App\Models\Correntista;

class CorrentistaView extends Component
{   public $empresa;
    public $empresaId;
 
    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
      
    }

    public function render()
    {
        return view('livewire.correntista-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
