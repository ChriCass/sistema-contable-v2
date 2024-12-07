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
use App\Models\CentroDeCostos;
use App\Services\CompraVentaService;
use Illuminate\Support\Facades\Session;

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
    public $idEmpresa;


    public function boot(CompraVentaService $compraVentaService)
    {
        $this->compraVentaService = $compraVentaService;
    }

    public function mount($index, $dataItem)
    {
        $this->idEmpresa = Session::get('EmpresaId');
        $this->index = $index;
        $this->dataItem = $dataItem;
        $this->libros = Libro::whereIn('N', ['01', '02'])->where('id_empresa',$this->idEmpresa['id'])->get();
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

    public function updated($propertyName){
        if($propertyName == 'dataItem.bas_imp'){
            $this -> calcularIgv();
        }elseif($propertyName == 'dataItem.igv' || $propertyName == 'dataItem.no_gravadas' || $propertyName == 'dataItem.isc' || $propertyName == 'dataItem.imp_bol_pla' || $propertyName == 'dataItem.otro_tributo'){
            $this->calcularPrecio();;
        }
    }
     
    
    public function calcularIgv()
    {

        if($this->dataItem['porcentaje'] == '18%'){
            $porcentaje = 0.18;
        }elseif($this->dataItem['porcentaje'] == '10%'){
            $porcentaje = 0.10;
        }else{
            $porcentaje = 0;
        }

        $bas_imp = $this->dataItem['bas_imp'];
        // Asegúrate de que 'bas_imp' existe y tiene un valor numérico. Si no, usa 0 como predeterminado.
        $baseImponible = isset($bas_imp) ? (float)$bas_imp : 0;

        // Calcular IGV con el porcentaje correspondiente y redondear a 2 decimales
        $this->dataItem['igv'] = round($baseImponible * $porcentaje, 2);
        $this->calcularPrecio();
    }
    
    public function calcularPrecio()
    {
        $this->dataItem['precio'] = round(
            floatval($this->dataItem['bas_imp'] ?? 0) + 
            floatval($this->dataItem['igv'] ?? 0) + 
            floatval($this->dataItem['no_gravadas'] ?? 0) + 
            floatval($this->dataItem['isc'] ?? 0) + 
            floatval($this->dataItem['imp_bol_pla'] ?? 0) + 
            floatval($this->dataItem['otro_tributo'] ?? 0), 
            2
        );
        
        
    }
    
    #[On('correntistaActualizado')]
    public function actualizarCorrentista($correntista)
    {
        $this->dataItem['correntistaData'] = $correntista;

        Log::info('Correntista actualizado en EditCompraVentaForm:', ['correntistaData' => $correntista]);
    }

    public function modal($tra){
        $modal['modal'] = True;
        $modal['traspaso'] = $tra;
        $this->dispatch('ModalCuentas', $modal); 
    }

    public function modalCentroCostos($tra)
    {
        // Registra en los logs para verificar que el método está siendo llamado
        Log::info('traspaso');
        
        // Crear un array con los datos que serán enviados en el evento
        $modal['modal'] = true; // El modal se abre
        $modal['traspaso'] = $tra; // Se asigna el valor del traspaso
        
        Log::info($modal);
        // Utiliza 'On' para emitir el evento 'ModalCC' junto con los datos
        $this->dispatch('CentroCostos', $modal); 
    }

    #[On('EdTraspasoCnta1')]
    public function handleEdTraspasoCnta1($traspado){
        $this -> dataItem['cnta1']['cuenta'] = $traspado['CtaCtable'];
    }

    #[On('EdTraspasoCnta2')]
    public function handleEdTraspasoCnta2($traspado){
        $this -> dataItem['cnta2']['cuenta'] = $traspado['CtaCtable'];
    }

    #[On('EdTraspasoCnta3')]
    public function handleEdTraspasoCnta3($traspado){
        $this -> dataItem['cnta3']['cuenta'] = $traspado['CtaCtable'];
    }

    #[On('EdTraspasoCntaPrecio')]
    public function handleEdTraspasoCntaPrecio($traspado){
        $this -> dataItem['cnta_precio']['cuenta'] = $traspado['CtaCtable'];
    }

    #[On('EdTraspasocta_otro_t')]
    public function handleEdTraspasocta_otro_t($traspado){
        $this -> dataItem['cta_otro_t']['cuenta'] = $traspado['CtaCtable'];
    }

    #[On('Edcta_detracc')]
    public function handleEdcta_detracc($traspado){
        $this -> dataItem['cta_detracc']['cuenta'] = $traspado['CtaCtable'];
    }

    #[On('EdTraspasoCC1')]
    public function handleEdTraspasoCC1($traspado){
        $this -> dataItem['cc1'] = $traspado['Id_cc'];
    }

    #[On('EdTraspasoCC2')]
    public function handleEdTraspasoCC2($traspado){
        $this -> dataItem['cc2'] = $traspado['Id_cc'];
    }

    #[On('EdTraspasoCC3')]
    public function handleEdTraspasoCC3($traspado){
        $this -> dataItem['cc3'] = $traspado['Id_cc'];
    }


    public function guardarCambios()
    {
        Log::info('Iniciando el proceso de submit en CompraVentaForm. Valor actual de editIndex: ' . $this->index);

        
         
        // Validación de los datos
        $validatedData = $this->validate([
            'dataItem.correntistaData' => 'required',
            'dataItem.libro' => 'required',
            'dataItem.fecha_doc' => 'required|date',
            'dataItem.fecha_ven' => 'required|date',
            'dataItem.fecha_vaucher' => 'required|date',
            'dataItem.num' => 'required',
            'dataItem.tdoc' => 'required',
            'dataItem.cod_moneda' => 'required|in:PEN,USD',
            'dataItem.opigv' => 'required',
            'dataItem.porcentaje' => 'required',
            'dataItem.bas_imp' => 'required',
            'dataItem.igv' => 'required',
            'dataItem.cnta_precio.cuenta' => 'required',
            'dataItem.glosa' => 'required',
            'dataItem.cnta1.cuenta' => 'required',
            'dataItem.mon1' => 'required',
            'dataItem.estado_doc' => 'required',
            'dataItem.estado' => 'required|integer',
            'dataItem.ser' => 'required',
            'dataItem.tip_cam' => 'nullable',
            'dataItem.no_gravadas' => 'nullable',
            'dataItem.isc' => 'nullable',
            'dataItem.imp_bol_pla' => 'nullable',
            'dataItem.otro_tributo' => 'nullable',
            'dataItem.precio' => 'required',
            'dataItem.mon2' => 'nullable',
            'dataItem.mon3' => 'nullable',
            'dataItem.cc1' => 'nullable',
            'dataItem.cc2' => 'nullable',
            'dataItem.cc3' => 'nullable',
            'dataItem.cta_otro_t.cuenta' => 'nullable',
            'dataItem.fecha_emod' => 'nullable',
            'dataItem.tdoc_emod' => 'nullable',
            'dataItem.ser_emod' => 'nullable',
            'dataItem.num_emod' => 'nullable',
            'dataItem.fec_emi_detr' => 'nullable',
            'dataItem.num_const_der' => 'nullable',
            'dataItem.tiene_detracc' => 'nullable',
            'dataItem.cta_detracc.cuenta' => 'nullable',
            'dataItem.mont_detracc' => 'nullable',
            'dataItem.ref_int1' => 'nullable',
            'dataItem.ref_int2' => 'nullable',
            'dataItem.ref_int3' => 'nullable'
        ]);

               

        $basImp = floatval($this->dataItem['bas_imp'] ?? 0);
        $no_gravadas = floatval($this->dataItem['no_gravadas'] ?? 0);
        $isc = floatval($this->dataItem['isc'] ?? 0);
        $impBolPla = floatval($this->dataItem['imp_bol_pla'] ?? 0);
        $otroTributo = floatval($this->dataItem['otro_tributo'] ?? 0);
        $valCabeceras = round($basImp + $no_gravadas + $isc + $impBolPla + $otroTributo, 2);
        
        $mon1 = floatval($this->dataItem['mon1'] ?? 0);
        $mon2 = floatval($this->dataItem['mon2'] ?? 0);
        $mon3 = floatval($this->dataItem['mon3'] ?? 0);
        $valMon = round($mon1 + $mon2 + $mon3, 2);
                    
        
        
        Log::info("ValCab:".$valCabeceras." valMon: ".$valMon);
        if($valCabeceras <> $valMon){
            session()->flash('error', "La sumatoria de montos de cabeceras: ".$valCabeceras. " con la suma de las montos asignados a cuentas: ".$valMon." no cuadra");
            return;
        }

        
        /*** SSWITCH - o -- Un service de validacion --- pero mas optimo - siwtch ----- ternarios(if mantenido) */
        if (!empty($this->dataItem['otro_tributo']) && empty($this->dataItem['cta_otro_t']['cuenta'])) {
            session()->flash('error', "Si pones un monto en otros tributos, necesitas una cuenta");
            return;
        }        
        if (!empty($this->dataItem['cta_otro_t']['cuenta']) && empty($this->dataItem['otro_tributo'])) {
            session()->flash('error', "Si pones una cuenta en otros tributos, necesitas un monto");
            return;
        }

        if (!empty($this->dataItem['mon2']) && empty($this->dataItem['cnta2']['cuenta'])) {
            session()->flash('error', "Si pones un monto en moneda2, necesitas una cuenta2");
            return;
        }        
        if (!empty($this->dataItem['cnta2']['cuenta']) && empty($this->dataItem['mon2'])) {
            session()->flash('error', "Si pones una cuenta en cuenta2, necesitas un moneda2");
            return;
        }

        if (!empty($this->dataItem['mon3']) && empty($this->dataItem['cnta3']['cuenta'])) {
            session()->flash('error', "Si pones un monto en moneda3, necesitas una cuenta3");
            return;
        }        
        if (!empty($this->dataItem['cnta3']['cuenta']) && empty($this->dataItem['mon3'])) {
            session()->flash('error', "Si pones una cuenta en cuenta3, necesitas un moneda3");
            return;
        }
        // Validación de cuentas
        if (!$this->validarCuenta($this->dataItem['cnta1']['cuenta'] ?? null, "La cuenta1 no se encuentra en el Plan Contable") ||
        !$this->validarCuenta($this->dataItem['cnta2']['cuenta'] ?? null, "La cuenta2 no se encuentra en el Plan Contable") ||
        !$this->validarCuenta($this->dataItem['cnta3']['cuenta'] ?? null, "La cuenta3 no se encuentra en el Plan Contable") ||
        !$this->validarCuenta($this->dataItem['cnta_precio']['cuenta'] ?? null, "La cuenta Precio no se encuentra en el Plan Contable") ||
        !$this->validarCuenta($this->dataItem['cta_otro_t']['cuenta'] ?? null, "La cuenta Otro Tributo no se encuentra en el Plan Contable") ||
        !$this->validarCuenta($this->dataItem['cta_detracc']['cuenta'] ?? null, "La cuenta de Detracción no se encuentra en el Plan Contable")) {
        return;
        }

        // Validación de centros de costos
        if (!$this->validarCentroCostos($this->dataItem['cc1'] ?? null, "El Centro de costos 1 no es válido") ||
        !$this->validarCentroCostos($this->dataItem['cc2'] ?? null, "El Centro de costos 2 no es válido") ||
        !$this->validarCentroCostos($this->dataItem['cc3'] ?? null, "El Centro de costos 3 no es válido")) {
        return;
        }
        Log::info('Terminando validacion');
        
        // Preparación de los datos utilizando el servicio
        $data = $this->compraVentaService->prepararDatos(
            $validatedData['dataItem'],
            $this->dataItem['usuario'] ?? null,
            $this->dataItem['empresa'] ?? null,
            $this->dataItem['correntistaData'] ?? null,
            $this->dataItem['libro'] ?? null,
            $this->dataItem['tdoc'] ?? null,
            $this->dataItem['igv'] ?? null,
            $this->dataItem['otro_tributo'] ?? null,
            $this->dataItem['tiene_detracc'] ?? null,
            $this->dataItem['precio'] ?? null,
            $this->dataItem['mont_detracc'] ?? null,
            $this->dataItem['mon1'] ?? null,
            $this->dataItem['mon2'] ?? null,
            $this->dataItem['mon3'] ?? null,
            $this->dataItem['cc1'] ?? null,
            $this->dataItem['cc2'] ?? null,
            $this->dataItem['cc3'] ?? null,
            $this->dataItem['tip_cam'] ?? null,
            $this->dataItem['cod_moneda'] ?? null,
            $this->dataItem['cnta1'] ?? null,
            $this->dataItem['cnta2'] ?? null,
            $this->dataItem['cnta3'] ?? null,
            $this->dataItem['ref_int1'] ?? null,  // <---- Pasar ref_int1
            $this->dataItem['ref_int2'] ?? null,  // <---- Pasar ref_int2
            $this->dataItem['ref_int3'] ?? null   // <---- Pasar ref_int3
        );

        
        // Disparar el evento para actualizar el componente padre
        $this->dispatch('dataUpdated', ['index' => $this->index, 'data' => $data]);
    
        // Cerrar el modal
        $this->openModal = false;
    
        Log::info('Modal cerrado después de guardar los cambios.');
        
    }

    private function validarCuenta($cuenta, $mensajeError) {
        if (!empty($cuenta)) {
            $cuentaValida = PlanContable::where('CtaCtable', $cuenta)->where('id_empresas',$this->idEmpresa['id'])->first();
            if (!$cuentaValida) {
                session()->flash('error', $mensajeError);
                return false;
            }
        }
        return true;
    }

    // Método para validar si el Centro de Costos existe
    private function validarCentroCostos($cc, $mensajeError) {
        if (!empty($cc)) {
            $centroValido = CentroDeCostos::where('Id', $cc)->where('id_empresa',$this->idEmpresa['id'])->first();
            if (!$centroValido) {
                session()->flash('error', $mensajeError);
                return false;
            }
        }
        return true;
    }
    
    
    public function render()
    {
        return view('livewire.edit-compra-venta-form');
    }
}
