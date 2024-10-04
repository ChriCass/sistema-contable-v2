<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;

class CompraVentaFormView extends Component
{
    public $empresaId;
    public $empresa;

    public function mount($id)
    {
        $this->empresaId = $id;
        $this->empresa = Empresa::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.compra-venta-form-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
