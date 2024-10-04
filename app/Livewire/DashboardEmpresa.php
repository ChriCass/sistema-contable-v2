<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
class DashboardEmpresa extends Component
{   
    
    
    public $empresa;
    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
    }
    public function render()
    {   
        return view('livewire.dashboard-empresa' )->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
