<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
class SeleccEmpresa extends Component
{   
    public $empresas;

    public function mount()
    {
        $this->empresas = Empresa::all();
    }

    public function render()
    {
        return view('livewire.selecc-empresa', ['empresas' => $this->empresas])->layout('layouts.select');
    }
}
