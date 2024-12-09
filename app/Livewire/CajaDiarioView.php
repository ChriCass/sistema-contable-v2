<?php

namespace App\Livewire;
use App\Models\Libro;
use App\Models\Mes;
use Livewire\Component;
use App\Models\Empresa;
class CajaDiarioView extends Component
{

    public $empresa;
    public $empresaId;
    public $libro;
    public $mes;
    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
        $this->libro = Libro::all();
        $this->mes = Mes::all();
    }

    public function render()
    {
        return view('livewire.caja-diario-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
