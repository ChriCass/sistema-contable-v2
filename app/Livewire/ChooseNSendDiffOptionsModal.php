<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Empresa;

class ChooseNSendDiffOptionsModal extends Component
{

    public $openModal = false;
    public $data = [];
    public $contenedor;
    public $filterColumn  = 'id';  // Columna por defecto
    public $searchValue;               // Valor de búsqueda

    public function updatedSearchValue()
    {
        $this->applyFilters();
    }

    public function updatedFilterColumn()
    {
        $this->applyFilters();

        //ESTA FUNCION JUEGA CON LOS CICLOS DE VIDA DEL COMPONENTE, EN ESTE CASO UPDATE LLAMA AL ACTUALIZAR AL APPLYFILTERS
        //POR DEFAULT FILTRA EMPRESAS, DEPENDE DE TI PARA QUE UTILZIARLO DEPENDIENDO DE CONSULTA
    }
    public function applyFilters()
    {
        // Obtener todas las empresas
        $empresas = collect($this->getAllData());
    
        // Limpiar el valor de búsqueda para evitar espacios innecesarios
        $searchValue = trim($this->searchValue);
    
        // Si el valor de búsqueda está vacío después de limpiar, mostramos todas las empresas
        if (empty($searchValue)) {
            $this->data = $empresas->all();
        } else {
            // Filtrar según la columna seleccionada y el valor ingresado
            $this->data = $empresas->filter(function ($empresa) use ($searchValue) {
                $filterColumn = $this->filterColumn;
    
                // Convertir a string para evitar errores
                $columnValue = (string) ($empresa->$filterColumn ?? '');
    
                // Comparación insensible a mayúsculas y minúsculas
                return stripos($columnValue, $searchValue) !== false;
            })->values()->all();
        }
    }
    


    public function getAllData()
    {
     
        return Empresa::all(); // Obtener todos los pendientes

        ///AQUI PODRIAS RECIBIR LA DATA MEDIANTE UNA CONDICIONAL EN UN SERVICE-RECUERDA QUE ESTE SE UTILIZARA DE FORMA UNIVERSAL
        /// PARA DISTINTOS PROCESOS, POR DEFECTO TENEMOS A EMPRESA
    }
    public function mount()
    {
        $this->data = $this->getAllData();
    }


    public function toggleSelection($id)
    {
        // Inicializa el contenedor si es null
        $this->contenedor = $this->contenedor ?? [];

        // Buscar el documento en la lista de pendientes
        $pendiente = collect($this->data)->firstWhere('id', $id);

        if ($pendiente) {
            if (collect($this->contenedor)->contains('id', $pendiente->id)) {
                $this->contenedor = array_filter($this->contenedor, function ($item) use ($pendiente) {
                    return $item->id !== $pendiente->id;
                });
                Log::info('Documento eliminado del contenedor', ['documento' => $pendiente]);
            } else {
                $this->contenedor[] = $pendiente;
                Log::info('Documento añadido al contenedor', ['documento' => $pendiente]);
            }
        }

        Log::info('Estado actual del contenedor', ['contenedor' => $this->contenedor]);
    }

    /* 
    public function resetSelection()
    {
        $this->contenedor = [];   // Limpia el contenedor
        $this->openModal = false; // Cierra el modal
        Log::info('El contenedor ha sido reiniciado y el modal ha sido cerrado');
    }
*/
    public function sendingData()
    {
        $this->dispatch('sendingContenedor', $this->contenedor);

        if (!empty($this->contenedor)) {
            // Almacenar mensaje de éxito en la sesión
            session()->flash('message', 'Datos enviados correctamente.');
            Log::info("El array se envió", ["contenedor" => $this->contenedor]);
        } else {
            // Almacenar mensaje de advertencia en la sesión
            session()->flash('warning', 'No se envió nada a la tabla.');
            Lo::info("No se envió nada a la tabla", ["contenedor" => $this->contenedor]);
        }
    }


    public function render()
    {
        return view('livewire.choose-n-send-diff-options-modal');
    }
}
