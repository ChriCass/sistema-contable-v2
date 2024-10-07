<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;

class RegistrarAsientoView extends Component
{

    public $rows = []; // Propiedad para almacenar las filas
    public $empresa;
    public $empresaId;

    public function mount($id)
    {
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
        // Inicializa con una fila vacía
        $this->rows[] = $this->newRow();
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
        // Añade una nueva fila vacía al arreglo
        $this->rows[] = $this->newRow();
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
