<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use App\Models\Libro;
use App\Models\Mes;
use App\Models\TipoDeMoneda;

class RegistrarAsientoView extends Component
{

    public $rows = []; // Propiedad para almacenar las filas
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
        // Inicializa con una fila vacía
        $this->rows[] = $this->newRow();
        $this->libro = Libro::all();
        $this->mes = Mes::all();
        $this->moneda = TipoDeMoneda::whereIn('COD', ['PEN', 'USD'])->get();
        

        $this->rows = [
            [
                'cn' => '',
                'descripcion' => '',
                'debe_soles' => '',
                'haber_soles' => '',
                'debe_dolares' => '',
                'haber_dolares' => '',
                'tc' => '',
                'glosa_especifica' => '',
                'numero' => '',
                'razon_social' => '',
                'tdoc' => '',
                'serie' => '',
                'num' => '',
                'npag' => '',
                'tpago' => '',
                'descripcion_pago' => '',
                'cc' => '',
                'estado' => '',
                'orden' => ''
            ]
        ];
    
    }

    public function newRow()
    {
        return [
            'cn' => '',
            'asiento' => '',
            'asiento_descripcion' => '',
            'debe_soles' => '',
            'haber' => '',
            'debe_dolares' => '',
            'haber_dolares' => '',
            'tc' => '',
            'glosa_especifica' => '',
            'razon_social' => '',
            'tdoc' => '',
            'ser' => '',
            'num' => '',
            'n_pag' => '',
            't_pago' => '',
            'descripcion_pago' => '',
            'cc' => '',
            'estado' => '',
            'orden' => ''
        ];
    }

    public function addRow()
    {
        $this->rows[] = [
            'cn' => '',
            'descripcion' => '',
            'debe_soles' => '',
            'haber_soles' => '',
            'debe_dolares' => '',
            'haber_dolares' => '',
            'tc' => '',
            'glosa_especifica' => '',
            'numero' => '',
            'razon_social' => '',
            'tdoc' => '',
            'serie' => '',
            'num' => '',
            'npag' => '',
            'tpago' => '',
            'descripcion_pago' => '',
            'cc' => '',
            'estado' => '',
            'orden' => ''
        ];
    }
    public function saveRows($rows)
    {
        // Aquí puedes iterar sobre $rows y guardar los datos en la base de datos
        // Esto puede incluir validaciones o transformaciones antes de guardar
        // Ejemplo:
        foreach ($rows as $row) {
            // Lógica de guardado, como validar y almacenar en un modelo
        }

        // Opcionalmente, puedes enviar un mensaje de éxito a la vista:
        session()->flash('message', 'Las filas se han guardado correctamente.');
    }


    public function render()
    {
        return view('livewire.registrar-asiento-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
