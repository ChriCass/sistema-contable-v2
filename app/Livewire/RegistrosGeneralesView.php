<?php

namespace App\Livewire;

use App\Models\Empresa;
use App\Models\Libro;
use App\Models\Mes;
use Livewire\Component;

class RegistrosGeneralesView extends Component
{
    public $empresa;
    public $empresaId;
    public $libro;
    public $mes;
    public $origen;

    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
        $this->libro = Libro::all();
        $this->mes = Mes::all();
        $this->origen = request()->get('origen');
    }

    public function render()
    {
        return view('livewire.registros-generales-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
