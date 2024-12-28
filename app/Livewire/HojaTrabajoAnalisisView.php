<?php

namespace App\Livewire;

use App\Models\Empresa;
use App\Models\Mes;
use Livewire\Component;

class HojaTrabajoAnalisisView extends Component
{   
    public $empresa;
    public $empresaId;
    public $años;
    public $mes;
    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
        $currentYear = now()->year;
        $this->años = [$currentYear, $currentYear + 1, $currentYear + 2];
        $this->mes = Mes::all();
    }
    public function render()
    {
        return view('livewire.hoja-trabajo-analisis-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
