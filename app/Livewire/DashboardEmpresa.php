<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DashboardEmpresa extends Component
{   
    
    
    public $empresa;
    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
        Log::info('Estas en la empresa:'.$this->empresa);
        Session::put('EmpresaId', $this->empresa);

    }
    public function render()
    {   
        return view('livewire.dashboard-empresa' )->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
