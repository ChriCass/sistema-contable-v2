<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
class CompraVenta extends Component
{    public $empresa;
    public $empresaId;
    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
       $this->empresaId = $this->empresa->id;
    }
    public function render()
    {
        return view('livewire.compra-venta', ['empresaId' => $this->empresaId])->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
