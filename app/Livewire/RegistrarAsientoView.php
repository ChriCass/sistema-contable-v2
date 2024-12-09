<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use App\Models\Libro;
use App\Models\Mes;
use App\Models\TipoDeMoneda;

class RegistrarAsientoView extends Component
{

     
    public $empresa;
    public $empresaId;
    public $libro;
    public $mes;
    public $moneda;
    public $index;
    public $options = [
        ['value' => '001', 'label' => 'Option 1'],
        ['value' => '002', 'label' => 'Option 2'],
        ['value' => '003', 'label' => 'Option 3'],
        // Agrega más opciones aquí
    ];

    public $filteredOptions = []; // Opciones filtradas
    public $query = ''; // Entrada del usuario
    public $selectedIndex = null; // Índice de fila en edición


    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
 
        $this->libro = Libro::all();
        $this->mes = Mes::all();
        $this->moneda = TipoDeMoneda::whereIn('COD', ['PEN', 'USD'])->get();
        

        
    }

   

    public function render()
    {
        return view('livewire.registrar-asiento-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
