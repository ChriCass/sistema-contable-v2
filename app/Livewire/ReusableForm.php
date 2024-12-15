<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Libro;
use App\Models\PlanContable;
use App\Models\Opigv;
use App\Models\EstadoDocumento;
use App\Models\Estado;
Use App\Models\TipoMedioDePago;
use App\Models\TipoComprobantePagoDocumento;
use Illuminate\Support\Facades\Log;
use App\Models\CentroDeCostos;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;

class ReusableForm extends Component
{
    public $CentrodeCostos;
    public $cuentas;
    public $idEmpresa;
    public $tipoPagos;
    public $estado_docs;
    public $estado_doc;
    public $estados;
    public $estado;
    public $cuentaId;
    public $descripcionCuenta;
    public $CC;
    public $TipoDeDocumentos;
    public $Tdoc;
    public $cuentaRep;
    public $correntistaData;
    public $glosa;
    public $DebeS;
    public $HaberS;
    public $DebeD;
    public $HaberD;
    public $Serie;
    public $Numero;
    public $Mpag;
    public $origen;
    public $index;
    public $edit = false;

    public function mount($tra)
    {
        $this -> CargarDatos();
        $this -> origen = $tra;
    }


    public function CargarDatos(){
        $this->idEmpresa = Session::get('EmpresaId');

        $this->TipoDeDocumentos = TipoComprobantePagoDocumento::all();
        $idEmpresa = $this->idEmpresa->id;

        $this->CentrodeCostos = CentroDeCostos::where('id_empresa', $idEmpresa)
        ->get();
         $this->tipoPagos = TipoMedioDePago::all();
 
        $this->cuentas = PlanContable::where('id_empresas', $idEmpresa)
        ->get()
        ->map(function ($item) {
            $item->descripcion = $item->descripcion ?? 'Descripción no disponible'; 
            return $item;
        });
    

        $this->estado_docs = EstadoDocumento::all();
        $this->estados = Estado::all();
    }


    public function PlanCont($tra){
        $modal['modal'] = True;
        $modal['traspaso'] = $tra;
        $this->dispatch('ModalCuentas', $modal);
    }

    #[On('Reg_Cuenta')]
    public function handleReg_Cuenta($traspado){
        $this -> cuentaId = $traspado['CtaCtable'];
    }

    #[On('correntistaEncontrado')]
    public function handleCorrentistaEncontrado($data)
    {
        Log::info('Correntista data received in CompraVentaForm: ', $data);
        $this->correntistaData = $data;
    }
    
    public function buscarCuenta()
{
    // Buscar la cuenta por ID y empresa
    $cuenta = PlanContable::where('CtaCtable', $this->cuentaId)
        ->where('id_empresas', $this->idEmpresa->id)  // Filtrar por empresaId
        ->first();  // Usamos first() ya que buscamos una única cuenta por ID
    if ($cuenta) {
        $this->descripcionCuenta = $cuenta->Descripcion;  // Actualizar la descripción
    } else {
        $this->descripcionCuenta = 'Cuenta no encontrada';  // En caso de que no exista la cuenta
    }
}

    public function submit(){
        if ($this->ValidateData() == 2) return;
        
        $data['Cnta'] = $this -> cuentaId;
        $data['DesCnta'] = $this -> descripcionCuenta;
        $data['DebeS'] = $this -> DebeS;
        $data['HaberS'] = $this -> HaberS;
        $data['DebeD'] = $this -> DebeD;
        $data['HaberD'] = $this -> HaberD;
        $data['GlosaEspecifica'] = $this -> glosa;
        $data['Corrent'] = $this->correntistaData['ruc'] ?? $this->correntistaData['ruc_emisor'] ?? $this->correntistaData['dni'] ?? null;
        $data['RazSocial'] = $this->correntistaData['nombre_o_razon_social'] ?? $this->correntistaData['nombre'] ?? null;
        $data['Tdoc'] = $this -> Tdoc ?? null;
        $data['Ser'] = $this -> Serie ?? null;
        $data['Num'] = $this -> Numero ?? null;
        $data['Mpag'] = $this -> Mpag ?? null;
        $data['CC'] = $this -> CC ?? null;
        $data['estado'] = $this -> estado;
        $data['estado_doc'] = $this -> estado_doc;
        
        $datosRegistro = [
            'origen' => $this->origen,
            'data' => $data,
        ];

        Log::info($this->origen);
        
        if ($this->origen != 1) {
            $datosRegistro['index'] = $this->index;
        }
        

        $this->dispatch('RegistroDeAsiento', $datosRegistro);

        $this -> resetVariables();
    }

    public function resetVariables() {
        $this->cuentaId = null;
        $this->descripcionCuenta = null;
        $this->DebeS = null;
        $this->HaberS = null;
        $this->DebeD = null;
        $this->HaberD = null;
        $this->glosa = null;
        $this->correntistaData = [];
        $this->Tdoc = null;
        $this->Serie = null;
        $this->Numero = null;
        $this->Mpag = null;
        $this->CC = null;
        $this->estado = null;
        $this->estado_doc = null;

        $this->dispatch('resetCorrentistaInput');
        $this -> origen = 1;
    }

    public function ValidateData(){
        $this -> validate([
            'cuentaId' => 'required',
            'descripcionCuenta' => 'required',
            'glosa' => 'required',
            'estado' => 'required',
            'estado_doc' => 'required',
            'DebeS' => 'nullable|numeric',
            'HaberS' => 'nullable|numeric',
            'DebeD' => 'nullable|numeric',
            'HaberD' => 'nullable|numeric'
        ]
        );

        
        if(empty($this->DebeS) && empty($this->HaberS)){
            session()->flash('error', 'En el debe y haber no pueden ser valores ceros');
            $val = 2;
        }elseif(!empty($this->DebeS) && !empty($this->HaberS)){
            session()->flash('error', 'Solo puede ser o Debe o Haber');
            $val = 2;
        }elseif($this -> descripcionCuenta == 'Cuenta no encontrada'){
            session()->flash('error', 'Se necesita una cuenta valida');
            $val = 2;
        }
        else{
            $val = 1;
        }

        return $val;

    }

    #[On('resetRAsientoGeneral')]
    public function handleresetRAsientoGeneral($estado)
    {
        $this -> resetVariables();
        $this -> origen = 1;
    }

    #[On('EditAsiento')]
    public function handleEditAsiento($traspasoEdit)
    {
        Log::info($traspasoEdit);
        $this -> origen = $traspasoEdit['origen'];
        $this -> index = $traspasoEdit['index'];
        $data = $traspasoEdit['data'];

        $this->cuentaId = $data['Cnta'];
        $this->descripcionCuenta = $data['DesCnta'];
        $this->DebeS = $data['DebeS'];
        $this->HaberS = $data['HaberS'];
        $this->DebeD = $data['DebeD'];
        $this->HaberD = $data['HaberD'];
        $this->glosa = $data['GlosaEspecifica'];
        if (!empty($data['Corrent']) && !empty($data['RazSocial'])) {
            $this->correntistaData = strlen($data['Corrent']) == 8 
                ? ['dni' => $data['Corrent'],'nombre' => $data['RazSocial']] 
                : ['ruc' => $data['Corrent'],'nombre_o_razon_social' => $data['RazSocial']];
                $this->dispatch('PasaCorrent',$this->correntistaData);
        } else {
            $this->correntistaData = null;
        }  
        $this->Tdoc = $data['Tdoc'];
        $this->Serie = $data['Ser'];
        $this->Numero = $data['Num'];
        $this->Mpag = $data['Mpag'];
        $this->CC = $data['CC'];
        $this->estado = $data['estado'];
        $this->estado_doc = $data['estado_doc'];

    }

    public function render()
    {
        return view('livewire.reusable-form');
    }
}
