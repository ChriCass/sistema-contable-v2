<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Libro;
use App\Models\PlanContable;
use App\Models\Opigv;
use App\Models\EstadoDocumento;
use App\Models\Estado;
use App\Models\CentroDeCostos;
use App\Models\TipoComprobantePagoDocumento;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use App\Services\CompraVentaService;
use SebastianBergmann\Type\TrueType;
use Illuminate\Support\Facades\Session;

class CompraVentaForm extends Component
{
    public $openModal;

    public $empresaId;
    public $libro, $fecha_doc, $fecha_ven, $tdoc, $ser, $num, $cod_moneda;
    public $tip_cam, $opigv, $bas_imp, $igv, $no_gravadas, $isc, $imp_bol_pla, $otro_tributo;
    public $precio, $glosa, $mon1, $mon2, $mon3;
    public $cc1, $cc2, $cc3, $fecha_emod, $tdoc_emod, $ser_emod, $num_emod;
    public $fec_emi_detr, $num_const_der, $tiene_detracc, $mont_detracc;
    public $ref_int1, $ref_int2, $ref_int3, $estado_doc, $estado;
    public $fecha_vaucher;
    public $usuario = [];
    public $libros, $opigvs, $estado_docs, $estados, $ComprobantesPago;
    public $correntistaData;
    public $cnta1 = ['cuenta' => '', 'DebeHaber' => null];
    public $cnta2 = ['cuenta' => '', 'DebeHaber' => null];
    public $cnta3 = ['cuenta' => '', 'DebeHaber' => null];
    public $cta_otro_t = ['cuenta' => '', 'DebeHaber' => null];
    public $cnta_precio = ['cuenta' => '', 'DebeHaber' => null, 'precioTotal' => null];
    public $cta_detracc = ['cuenta' => '', 'DebeHaber' => null];
    public $porcentaje = '';
    public $montoDolares = [];
    public $igv_manual = false;
    public $editIndex = null; // Para almacenar el índice del dato que se está editando
    protected $compraVentaService;
    protected $rules = [
        'bas_imp' => 'nullable|numeric',
        'igv' => 'nullable|numeric',
        'isc' => 'nullable|numeric',
        'imp_bol_pla' => 'nullable|numeric',
        'otro_tributo' => 'nullable|numeric',
    ];

    public $mostrarFormulario = false; // Propiedad para controlar visibilidad
    public $idEmpresa;

    public function toggleFormulario()
    {
        $this->mostrarFormulario = !$this->mostrarFormulario;
        $this->resetFields();
    }

    public function mount()
    {
        $this->idEmpresa = Session::get('EmpresaId');
        $this->libros = Libro::whereIn('N', ['01', '02'])->where('id_empresa',$this->idEmpresa['id'])->get();
        $this->opigvs = Opigv::all();
        $this->estado_docs = EstadoDocumento::all();
        $this->estados = Estado::all()->map(function ($estado) {
            Log::info('Estado cargado: ', ['N' => $estado->N, 'Descripcion' => $estado->DESCRIPCION]);
            return $estado;
        });
        $this->ComprobantesPago = TipoComprobantePagoDocumento::all();
        $this->usuario = Auth::user();
        
    }

    
    // Inyectar el servicio en el método boot
    public function boot(CompraVentaService $compraVentaService)
    {
        $this->compraVentaService = $compraVentaService;
        $this->usuario = Auth::user();
    }



    #[On('correntistaEncontrado')]
    public function handleCorrentistaEncontrado($data)
    {
        Log::info('Correntista data received in CompraVentaForm: ', $data);
        $this->correntistaData = $data;
    }

    #[On('tipoCambioEncontrado')]
    public function handleTipoCambioEncontrado($data)
    {
        Log::info('El tipo de cambio encontrado es: ', $data);
        $this->tip_cam = is_numeric($data['precio_venta']) ? round((float)$data['precio_venta'], 2) : 0.00;
    }

    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($propertyName == 'igv') {
            $this->igv_manual = true;
        } elseif ($propertyName == 'porcentaje') {
            $this->igv_manual = false;
            $this->calcularIgv();
        } else {
            if (!$this->igv_manual) {
                $this->calcularIgv();
            }
            $this->calcularPrecio();
        }
    }

    public function calcularIgv()
    {
        $basImp = floatval($this->bas_imp);
        $porcentaje = floatval($this->porcentaje);
    
        if ($basImp && $porcentaje) {
            $this->igv = round(($basImp * $porcentaje) / 100, 2);
        } else {
            $this->igv = null;
        }
    }    

    public function updatedigv($value){
        $this->igv = $value;
        $this -> calcularPrecio();
    }
    
    public function calcularPrecio()
    {
        $basImp = floatval($this->bas_imp ?: 0);
        $igv = floatval($this->igv ?: 0);
        $no_gravadas = floatval($this->no_gravadas ?: 0);
        $isc = floatval($this->isc ?: 0);
        $impBolPla = floatval($this->imp_bol_pla ?: 0);
        $otroTributo = floatval($this->otro_tributo ?: 0);
    
        $this->precio = round($basImp + $igv + $no_gravadas + $isc + $impBolPla + $otroTributo, 2);
    }
    

    
    public function submit()
    {
        Log::info('Iniciando el proceso de submit en CompraVentaForm. Valor actual de editIndex: ' . $this->editIndex);

        // Validación de los datos
        $validatedData = $this->validate([
            'correntistaData' => 'required',
            'libro' => 'required',
            'fecha_doc' => 'required|date',
            'fecha_ven' => 'required|date',
            'fecha_vaucher' => 'required|date',
            'num' => 'required',
            'tdoc' => 'required',
            'cod_moneda' => 'required|in:PEN,USD',
            'opigv' => 'required',
            'porcentaje' => 'required',
            'bas_imp' => 'required',
            'igv' => 'required',
            'cnta_precio.cuenta' => 'required',
            'glosa' => 'required',
            'cnta1.cuenta' => 'required',
            'mon1' => 'required',
            'estado_doc' => 'required',
            'estado' => 'required|integer',
            'ser' => 'required',
            'tip_cam' => 'nullable',
            'no_gravadas' => 'nullable',
            'isc' => 'nullable',
            'imp_bol_pla' => 'nullable',
            'otro_tributo' => 'nullable',
            'precio' => 'required',
            'mon2' => 'nullable',
            'mon3' => 'nullable',
            'cc1' => 'nullable',
            'cc2' => 'nullable',
            'cc3' => 'nullable',
            'cta_otro_t.cuenta' => 'nullable',
            'fecha_emod' => 'nullable',
            'tdoc_emod' => 'nullable',
            'ser_emod' => 'nullable',
            'num_emod' => 'nullable',
            'fec_emi_detr' => 'nullable',
            'num_const_der' => 'nullable',
            'tiene_detracc' => 'nullable',
            'cta_detracc.cuenta' => 'nullable',
            'mont_detracc' => 'nullable',
            'ref_int1' => 'nullable',
            'ref_int2' => 'nullable',
            'ref_int3' => 'nullable'
        ]);

        $basImp = floatval($this->bas_imp ?: 0);
        $no_gravadas = floatval($this->no_gravadas ?: 0);
        $isc = floatval($this->isc ?: 0);
        $impBolPla = floatval($this->imp_bol_pla ?: 0);
        $otroTributo = floatval($this->otro_tributo ?: 0);
        $valCabeceras = round($basImp + $no_gravadas + $isc + $impBolPla + $otroTributo, 2);
        $mon1 = floatval($this->mon1 ?: 0);
        $mon2 = floatval($this->mon2 ?: 0);
        $mon3 = floatval($this->mon3 ?: 0);
        $valMon = round($mon1+$mon2+$mon3,2);
        Log::info("ValCab:".$valCabeceras." valMon: ".$valMon);
        if($valCabeceras <> $valMon){
            session()->flash('error', "La sumatoria de montos de cabeceras: ".$valCabeceras. " con la suma de las montos asignados a cuentas: ".$valMon." no cuadra");
            return;
        }
        if (!empty($this->otro_tributo) && empty($this->cta_otro_t['cuenta'])) {
            session()->flash('error', "Si pones un monto en otros tributos, necesitas una cuenta");
            return;
        }        
        if (!empty($this->cta_otro_t['cuenta']) && empty($this->otro_tributo)) {
            session()->flash('error', "Si pones una cuenta en otros tributos, necesitas un monto");
            return;
        }

        if (!empty($this->mon2) && empty($this->cnta2['cuenta'])) {
            session()->flash('error', "Si pones un monto en moneda2, necesitas una cuenta2");
            return;
        }        
        if (!empty($this->cnta2['cuenta']) && empty($this->mon2)) {
            session()->flash('error', "Si pones una cuenta en cuenta2, necesitas un moneda2");
            return;
        }

        if (!empty($this->mon3) && empty($this->cnta3['cuenta'])) {
            session()->flash('error', "Si pones un monto en moneda3, necesitas una cuenta3");
            return;
        }        
        if (!empty($this->cnta3['cuenta']) && empty($this->mon3)) {
            session()->flash('error', "Si pones una cuenta en cuenta3, necesitas un moneda3");
            return;
        }
        // Validación de cuentas
        if (!$this->validarCuenta($this->cnta1['cuenta'], "La cuenta1 no se encuentra en el Plan Contable") ||
        !$this->validarCuenta($this->cnta2['cuenta'], "La cuenta2 no se encuentra en el Plan Contable") ||
        !$this->validarCuenta($this->cnta3['cuenta'], "La cuenta3 no se encuentra en el Plan Contable") ||
        !$this->validarCuenta($this->cnta_precio['cuenta'], "La cuenta Precio no se encuentra en el Plan Contable") ||
        !$this->validarCuenta($this->cta_otro_t['cuenta'], "La cuenta Otro Tributo no se encuentra en el Plan Contable") ||
        !$this->validarCuenta($this->cta_detracc['cuenta'], "La cuenta de Detracción no se encuentra en el Plan Contable")) {
        return;
        }

        // Validación de centros de costos
        if (!$this->validarCentroCostos($this->cc1, "El Centro de costos 1 no es válido") ||
        !$this->validarCentroCostos($this->cc2, "El Centro de costos 2 no es válido") ||
        !$this->validarCentroCostos($this->cc3, "El Centro de costos 3 no es válido")) {
        return;
        }
        Log::info('Terminando validacion');
    
         // Preparación de los datos utilizando el servicio
    $data = $this->compraVentaService->prepararDatos(
        $validatedData,
        $this->usuario,
        $this->empresaId,
        $this->correntistaData,
        $this->libro,
        $this->tdoc,
        $this->igv,
        $this->otro_tributo,
        $this->tiene_detracc,
        $this->precio,
        $this->mont_detracc,
        $this->mon1,
        $this->mon2,
        $this->mon3,
        $this->cc1,
        $this->cc2,
        $this->cc3,
        $this->tip_cam,
        $this->cod_moneda,
        $this->cnta1,
        $this->cnta2,
        $this->cnta3,
        $this->ref_int1,  // <---- Pasar ref_int1
        $this->ref_int2,  // <---- Pasar ref_int2
        $this->ref_int3   // <---- Pasar ref_int3
    );
  


        // Dispatch para enviar los datos al componente CompraVentaTable
        $this->dispatch('dataSubmitted', $data);

        Log::info('Evento dataSubmitted disparado. Datos:', $data);

        // Resetear campos después del submit
        $this->resetFields();
        Log::info('Campos del formulario reseteados después del submit.');
        $this->mostrarFormulario = false;
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


    #[On('TraspasoCnta1')]
    public function handleTraspasoCnta1($traspado){
        $this -> cnta1['cuenta'] = $traspado['CtaCtable'];
    }

    #[On('TraspasoCnta2')]
    public function handleTraspasoCnta2($traspado){
        $this -> cnta2['cuenta'] = $traspado['CtaCtable'];
    }

    #[On('TraspasoCnta3')]
    public function handleTraspasoCnta3($traspado){
        $this -> cnta3['cuenta'] = $traspado['CtaCtable'];
    }

    #[On('TraspasoCntaPrecio')]
    public function handleTraspasoCntaPrecio($traspado){
        $this -> cnta_precio['cuenta'] = $traspado['CtaCtable'];
    }

    #[On('Traspasocta_otro_t')]
    public function handleTraspasocta_otro_t($traspado){
        $this -> cta_otro_t['cuenta'] = $traspado['CtaCtable'];
    }

    #[On('cta_detracc')]
    public function handlecta_detracc($traspado){
        $this -> cta_detracc['cuenta'] = $traspado['CtaCtable'];
    }

    #[On('TraspasoCC1')]
    public function handleTraspasoCC1($traspado){
        $this -> cc1 = $traspado['Id_cc'];
    }

    #[On('TraspasoCC2')]
    public function handleTraspasoCC2($traspado){
        $this -> cc2 = $traspado['Id_cc'];
    }

    #[On('TraspasoCC3')]
    public function handleTraspasoCC3($traspado){
        $this -> cc3 = $traspado['Id_cc'];
    }

    public function resetFields()
    {
        $this->empresaId = $this->empresaId ?? 1;
        $this->libro = null;
        $this->fecha_doc = null;
        $this->fecha_ven = null;
        $this->tdoc = null;
        $this->ser = null;
        $this->num = null;
        $this->cod_moneda = null;
        $this->tip_cam = null;
        $this->opigv = null;
        $this->bas_imp = null;
        $this->igv = null;
        $this->no_gravadas = null;
        $this->isc = null;
        $this->imp_bol_pla = null;
        $this->otro_tributo = null;
        $this->precio = null;
        $this->glosa = null;
        $this->mon1 = null;
        $this->mon2 = null;
        $this->mon3 = null;
        $this->cc1 = null;
        $this->cc2 = null;
        $this->cc3 = null;
        $this->fecha_emod = null;
        $this->tdoc_emod = null;
        $this->ser_emod = null;
        $this->num_emod = null;
        $this->fec_emi_detr = null;
        $this->num_const_der = null;
        $this->tiene_detracc = null;
        $this->mont_detracc = null;
        $this->ref_int1 = null;
        $this->ref_int2 = null;
        $this->ref_int3 = null;
        $this->estado_doc = null;
        $this->estado = null;
        $this->fecha_vaucher = null;
        $this->correntistaData = null;
        $this->cnta1 = ['cuenta' => '', 'DebeHaber' => null];
        $this->cnta2 = ['cuenta' => '', 'DebeHaber' => null];
        $this->cnta3 = ['cuenta' => '', 'DebeHaber' => null];
        $this->cta_otro_t = ['cuenta' => '', 'DebeHaber' => null];
        $this->cnta_precio = ['cuenta' => '', 'DebeHaber' => null, 'precioTotal' => null];
        $this->cta_detracc = ['cuenta' => '', 'DebeHaber' => null];
        $this->porcentaje = '';
        $this->montoDolares = [];
        $this->igv_manual = false;

        $this->dispatch('resetCorrentistainput');

    }

    // Método para validar si la cuenta existe en el Plan Contable
    private function validarCuenta($cuenta, $mensajeError) {
        if (!empty($cuenta)) {
            //$this->idEmpresa
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
        Log::info('Renderizando la vista de CompraVentaForm. Valor de editIndex: ' . $this->editIndex);
        return view('livewire.compra-venta-form');
    }
    
    
}
