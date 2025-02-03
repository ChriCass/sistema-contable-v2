<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Empresa;
use Illuminate\Support\Facades\Session;

class ChooseNSendDiffOptionsModal extends Component
{

    public $openModal = false;
    public $data = [];
    public $contenedor;
    public $filterColumn  = 'id';  // Columna por defecto
    public $searchValue;              // Valor de búsqueda
    public $cuenta;
    public $idEmpresa;
    public $dataoriginal;

    public function updatedcuenta($value)
    {
        
        $this -> consultaCuentas($value);
        
    }

    public function consultaCuentas($value){
        if(strlen($value) > 1){
            
            $empresaId = $this->idEmpresa['id'];

            $xsql = "CALL cuentaPendientes('$value', '$empresaId')";
        
            $this->data = collect(DB::select($xsql));
            $this->dataoriginal = $this->data;
        }
    }


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
        $empresas = collect($this->dataoriginal);

        Log::info($empresas);

        // Limpiar el valor de búsqueda para evitar espacios innecesarios
        $searchValue = trim($this->searchValue);

        // Log para ver el valor de búsqueda y la columna seleccionada
        Log::info('Búsqueda realizada', [
            'searchValue' => $searchValue,
            'filterColumn' => $this->filterColumn
        ]);

        // Si el valor de búsqueda está vacío después de limpiar, mostramos todas las empresas
        if (empty($searchValue)) {

            $this->data = $empresas->all();
            Log::info('Mostrando todas las empresas');

        } else {
            // Filtrar según la columna seleccionada y el valor ingresado
            $this->data = $empresas->filter(function ($empresa) use ($searchValue) {
                $filterColumn = $this->filterColumn;

                // Convertir a string para evitar errores
                $columnValue = (string) ($empresa->$filterColumn ?? '');

                // Log para ver los valores comparados
                Log::info('Comparando valores', [
                    'columnValue' => $columnValue,
                    'searchValue' => $searchValue
                ]);

                // Comparación insensible a mayúsculas y minúsculas
                return stripos($columnValue, $searchValue) !== false;
            })->values()->all();

            Log::info('Empresas filtradas', ['filteredData' => $this->data]);
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
        //$this->data = $this->getAllData();
        $this->idEmpresa = Session::get('EmpresaId');
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
            foreach ($this->contenedor as $cont) {

                $data['Cnta'] = $cont->CtaCtable;
                $data['DesCnta'] = $cont->Descripcion;
                $data['DebeS'] = $cont->Haber ?? null;
                $data['HaberS'] = $cont->Debe ?? null;
                $data['DebeD'] =  null;
                $data['HaberD'] =  null;
                $data['GlosaEspecifica'] = $cont->nombre_o_razon_social.' '.$cont->Ser.'-'.$cont->Num;
                $data['Corrent'] = $cont->ruc_emisor;
                $data['RazSocial'] = $cont->nombre_o_razon_social;
                $data['Tdoc'] = $cont->Tdoc?? null;
                $data['Ser'] = $cont->Ser ?? null;
                $data['Num'] = $cont->Num ?? null;
                $data['Mpag'] = null;
                $data['CC'] = null;
                $data['estado'] = 'APROBADO';
                $data['estado_doc'] = 'Documento';

                $datoApasar[] = $data;
            }
            
            $this->dispatch('PasarDeudas', $datoApasar);

        } else {
            // Almacenar mensaje de advertencia en la sesión
            session()->flash('warning', 'No se envió nada a la tabla.');
            Log::info("No se envió nada a la tabla", ["contenedor" => $this->contenedor]);
        }
    }


    public function render()
    {
        return view('livewire.choose-n-send-diff-options-modal');
    }
}
