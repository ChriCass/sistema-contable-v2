<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Libro;
use App\Models\PlanContable;
use App\Models\Opigv;
use App\Models\EstadoDocumento;
use App\Models\Estado;
use App\Models\TipoComprobantePagoDocumento;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use App\Services\CompraVentaService;

class EditCompraVentaForm extends Component
{
    public $openModal = false;
    public $index;
    public $dataItem;
    public $libros, $opigvs, $estado_docs, $estados, $ComprobantesPago;
    public $igv_manual = false; // Nuevo para manejar si el IGV es manual
    public $bas_imp, $porcentaje, $igv, $isc, $imp_bol_pla, $otro_tributo, $precio; // Variables relacionadas
    protected $compraVentaService;
    protected $rules = [
        'bas_imp' => 'nullable|numeric',
        'igv' => 'nullable|numeric',
        'isc' => 'nullable|numeric',
        'imp_bol_pla' => 'nullable|numeric',
        'otro_tributo' => 'nullable|numeric',
    ];

    public function boot(CompraVentaService $compraVentaService)
    {
        $this->compraVentaService = $compraVentaService;
    }

    public function mount($index, $dataItem)
    {
        $this->index = $index;
        $this->dataItem = $dataItem;
        $this->libros = Libro::whereIn('N', ['01', '02'])->get();
        $this->opigvs = Opigv::all();
        $this->estado_docs = EstadoDocumento::all();
        $this->estados = Estado::all()->map(function ($estado) {
            Log::info('Estado cargado: ', ['N' => $estado->N, 'Descripcion' => $estado->DESCRIPCION]);
            return $estado;
        });
        $this->ComprobantesPago = TipoComprobantePagoDocumento::all();

        // Inicializar las variables con los datos recibidos
        $this->bas_imp = $dataItem['bas_imp'] ?? 0;
         
        $this->igv = $dataItem['igv'] ?? 0;
        $this->isc = $dataItem['isc'] ?? 0;
        $this->imp_bol_pla = $dataItem['imp_bol_pla'] ?? 0;
        $this->otro_tributo = $dataItem['otro_tributo'] ?? 0;
        $this->precio = $dataItem['precio'] ?? 0;
    }

     
    
    public function calcularIgv()
    {
        $this->dataItem['igv'] = round(($this->dataItem['bas_imp'] * $this->dataItem['porcentaje']) / 100, 2);
        $this->calcularPrecio();  // Actualiza el precio cada vez que cambia el IGV
    }
    
    public function calcularPrecio()
    {
        $this->dataItem['precio'] = round(
            $this->dataItem['bas_imp'] +
            $this->dataItem['igv'] +
            $this->dataItem['isc'] +
            $this->dataItem['imp_bol_pla'] +
            $this->dataItem['otro_tributo'], 
            2
        );
    }
    
    #[On('correntistaActualizado')]
public function actualizarCorrentista($correntista)
{
    $this->dataItem['correntistaData'] = $correntista;

    Log::info('Correntista actualizado en EditCompraVentaForm:', ['correntistaData' => $correntista]);
}


    public function guardarCambios()
    {
        Log::info('Iniciando el proceso de guardar cambios...');
        Log::info('Datos actuales antes de asignar DebeHaber:', [
            'dataItem' => $this->dataItem,
            'libro' => $this->dataItem['libro'],
            'cnta1' => $this->dataItem['cnta1']
        ]);
    
        // Asignar DebeHaber antes de preparar datos
        Log::info('Asignando DebeHaber basado en el libro...');
        $this->compraVentaService->asignarDebeHaber($this->dataItem, $this->dataItem['libro']);
        Log::info('Datos después de asignar DebeHaber:', [
            'dataItem' => $this->dataItem,
            'libro' => $this->dataItem['libro'],
            'cnta1' => $this->dataItem['cnta1']
        ]);
    
        // Preparación de los datos utilizando el servicio
        $data = $this->compraVentaService->prepararDatos(
            $this->dataItem,
            $this->dataItem['usuario'],  // Usar los datos del usuario directamente del array
            $this->dataItem['empresa'],  // Usar los datos de la empresa directamente del array
            $this->dataItem['correntistaData'],
            $this->dataItem['libro'],
            $this->dataItem['tdoc'],
            $this->dataItem['igv'],
            $this->dataItem['otro_tributo'] ?? null,
            $this->dataItem['tiene_detracc'] ?? null,
            $this->dataItem['precio'],
            $this->dataItem['mont_detracc'] ?? null,
            $this->dataItem['mon1'],
            $this->dataItem['mon2'] ?? null,
            $this->dataItem['mon3'] ?? null,
            $this->dataItem['cc1'] ?? null,
            $this->dataItem['cc2'] ?? null,
            $this->dataItem['cc3'] ?? null,
            $this->dataItem['tip_cam'] ?? null,
            $this->dataItem['cod_moneda'],
            $this->dataItem['cnta1'],
            $this->dataItem['cnta2'] ?? null,
            $this->dataItem['cnta3'] ?? null,
            $this->dataItem['ref_int1'] ?? null,
            $this->dataItem['ref_int2'] ?? null,
            $this->dataItem['ref_int3'] ?? null
        );
    
        Log::info('Datos preparados después de la llamada al servicio compraVentaService:', [
            'data' => $data,
            'libro' => $data['libro'],
            'cnta1' => $data['cnta1'],
        ]);
    
        // Disparar el evento para actualizar el componente padre
        $this->dispatch('dataUpdated', ['index' => $this->index, 'data' => $data]);
    
        Log::info('Evento dataUpdated disparado para el índice:', [
            'index' => $this->index,
            'data' => $data,
            'libro' => $data['libro'],
            'cnta1' => $data['cnta1'],
        ]);
    
        // Cerrar el modal
        $this->openModal = false;
    
        Log::info('Modal cerrado después de guardar los cambios.');
    }
    
    
    public function render()
    {
        return view('livewire.edit-compra-venta-form');
    }
}
