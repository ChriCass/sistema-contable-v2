<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use App\Models\Libro;
use App\Models\Mes;
use App\Models\TipoDeMoneda;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\Foreach_;
use App\Models\TipoComprobantePagoDocumento;
use App\Models\TipoMedioDePago;
use App\Models\Estado;
use App\Models\EstadoDocumento;
use App\Models\OpIgv;
use App\Models\ClasificacionBienServicio;
use App\Services\RegistroAsientoService;
use Carbon\Carbon;
use App\Models\Tabla;
use PhpParser\Node\Stmt\Return_;
use App\Models\CentroDeCostos;
use App\Models\TipoDocumentoIdentidad;
use Illuminate\Support\Facades\DB;

class RegistrarAsientoView extends Component
{

    public $dataAsiento = [];     
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
    public $tipForm;
    public bool $openForm = false;
    public $tra;
    public $lib;
    public $mss;
    public $mon;
    public $glosa;
    public $fecha_vaucher;
    public $de = 0;
    public $ha = 0;
    public $to = 0;
    protected $registroAsientoService;
    public $origen;
    public $vou;
    public $voucher;
    public $lb;
    public $ms;
    public $vo;
    public $conven;
    public $TipoDeDocumentos;
    public $TipoDeDocIdentidad;
    public $TipoOpIgv;
    public $TipoDeClasificacionBienes;
    public $Fecha_Doc;
    public $Fecha_Ven;
    public $TDoc;
    public $Ser;
    public $ADuaDsi;
    public $Num;
    public $idt02doc;
    public $ruc_emisor;
    public $nombre_o_razon_social;
    public $TOpIgv;
    public $BasImp;
    public $IGV;
    public $NoGravadas;
    public $ISC;
    public $ImpBolPla;
    public $OtroTributo;
    public $total;
    public $TipCam;
    public $FechaEMod;
    public $TDocEMod;
    public $SerEMod;
    public $CodDepenDUAoDSI;
    public $NumEMod;
    public $FecEmiDetr;
    public $NumConstDer;
    public $ClasBienes;

    public function mount($id)
    {
        $this -> origen = request()->get('origen');
        
        $this->cargardatosGenerales($id);
        $this->GeneradorDeRegistros($this -> origen,$id);
        
    }

    public function GeneradorDeRegistros($origen,$id){
        $this->dataAsiento = Session::get('RegistroAsiento', []);
        
        if($origen == 'registrar_asiento'){
            $this -> tipForm = 'Registro de Asiento';
        }elseif($origen == 'editar_asiento'){
            $this -> tipForm = 'Editar Asiento';
            $this->lb = request()->get('libro');
            $this->ms = request()->get('mes');
            $this->vo = request()->get('vou');
            $conven = Libro::select('DESCRIPCION')->where('id',$this->lb)->get()->first()->toarray();
            $this->conven = ($conven['DESCRIPCION'] == 'COMPRAS' || $conven['DESCRIPCION'] == 'VENTAS') ? 1 : 0;
            $cab = DB::select('CALL cabecera(?, ?, ?, ?)', [
                $this->ms,      
                $this->lb,      
                $this->vo,
                $id
            ]);
            $this -> mss = $cab[0]->Mes;
            $this -> lib = $cab[0]->N;
            $this -> fecha_vaucher = $cab[0]->Fecha_Vou;
            $this -> glosa = $cab[0]->GlosaGeneral;
            $this -> mon = $cab[0]->CodMoneda;
            $this -> voucher = $cab[0]->Vou;

            if ($this -> conven == '1'){
                $this -> CargardatosComprasVentas();
                $cabComprasVentas = DB::select('CALL ComprasVentasDetalle(?, ?, ?, ?)', [     
                    $this->lb,
                    $this->ms, 
                    $this->vo,
                    $id
                ]); 

                $this->Fecha_Doc = $cabComprasVentas[0]->Fecha_Doc;
                $this->Fecha_Ven = $cabComprasVentas[0]->Fecha_Ven;
                $this->TDoc = $cabComprasVentas[0]->TDoc;
                $this->Ser = $cabComprasVentas[0]->Ser;
                $this->ADuaDsi = $cabComprasVentas[0]->ADuaDsi;
                $this->Num = $cabComprasVentas[0]->Num;
                $this->idt02doc = strval($cabComprasVentas[0]->idt02doc);
                $this->ruc_emisor = $cabComprasVentas[0]->ruc_emisor;
                $this->nombre_o_razon_social = $cabComprasVentas[0]->nombre_o_razon_social;
                $this->TOpIgv = $cabComprasVentas[0]->TOpIgv;
                $this->BasImp = $cabComprasVentas[0]->BasImp;
                $this->IGV = $cabComprasVentas[0]->IGV;
                $this->NoGravadas = $cabComprasVentas[0]->NoGravadas;
                $this->ISC = $cabComprasVentas[0]->ISC;
                $this->ImpBolPla = $cabComprasVentas[0]->ImpBolPla;
                $this->OtroTributo = $cabComprasVentas[0]->OtroTributo;
                $this->total = $cabComprasVentas[0]->total;
                $this->TipCam = $cabComprasVentas[0]->TipCam;
                $this->FechaEMod = $cabComprasVentas[0]->FechaEMod;
                $this->TDocEMod = $cabComprasVentas[0]->TDocEMod;
                $this->SerEMod = $cabComprasVentas[0]->SerEMod;
                $this->CodDepenDUAoDSI = $cabComprasVentas[0]->CodDepenDUAoDSI;
                $this->NumEMod = $cabComprasVentas[0]->NumEMod;
                $this->FecEmiDetr = $cabComprasVentas[0]->FecEmiDetr;
                $this->NumConstDer = $cabComprasVentas[0]->NumConstDer;
                $this->ClasBienes = $cabComprasVentas[0]->ClasBienes;
        
            }

            $asientos = DB::select('CALL asiento_contable(?, ?, ?, ?)', [
                $this->ms,      
                $this->lb,      
                $this->vo,
                $id
            ]);            

            foreach ($asientos as $asiento){
                $ass['Cnta'] = $asiento->CtaCtable;
                $ass['DesCnta'] = $asiento->Descripcion;
                $ass['DebeS'] = $asiento->Debe;
                $ass['HaberS'] = $asiento->Haber;
                $ass['DebeD'] = $asiento->DebeDo;
                $ass['HaberD'] = $asiento->HaberDo;
                $ass['GlosaEspecifica'] = $asiento->GlosaEpecifica;
                $ass['Corrent'] = $asiento->ruc_emisor;
                $ass['RazSocial'] = $asiento->nombre_o_razon_social;
                $ass['Tdoc'] = $asiento->DesTdoc;
                $ass['Ser'] = $asiento->Ser;
                $ass['Num'] = $asiento->Num;
                $ass['Mpag'] = $asiento->DesMpag;
                $ass['CC'] = $asiento->DesCC;
                $ass['estado'] = $asiento->EstDesc;
                $ass['estado_doc'] = $asiento->EstDoc;
                
                $this ->dataAsiento[] = $ass;
            }
        }
        
        count($this->dataAsiento) !== 0 ? $this->DebeHaber($this->dataAsiento) : ($this->de = $this->ha = $this->to = 0);
        
    }

    public function CargardatosComprasVentas(){
        $this -> TipoDeDocumentos = TipoComprobantePagoDocumento::all();
        $this -> TipoDeDocIdentidad = TipoDocumentoIdentidad::whereIn('N',['1','6'])->get()->toarray();
        $this -> TipoOpIgv = OpIgv::all();
        $this -> TipoDeClasificacionBienes = ClasificacionBienServicio::all();
    }

    public function hydrate(RegistroAsientoService $registroAsientoService)
    {
        $this -> registroAsientoService = $registroAsientoService;
    }

    public function DebeHaber($data)
    {
        $debe = 0;
        $haber = 0;

        foreach ($data as $fila) {
            $debe += (float) $fila['DebeS']; // Convierte a float
            $haber += (float) $fila['HaberS']; // Convierte a float
        }

        $this->de = $debe;
        $this->ha = $haber;
        $this->to = round($debe - $haber,2);
    }


    public function cargardatosGenerales($id){
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
 
        $this->libro = Libro::where('id_empresa',$this->empresaId)->get()->toArray();
        $this->mes = Mes::all()->toArray();
        $this->moneda = TipoDeMoneda::whereIn('COD', ['PEN', 'USD'])->get()->toArray();
        $this->tra = 1;
    }
   
    #[On('RegistroDeAsiento')]
    public function handleRegistroDeAsiento($data){
        $this -> openForm = false;
        if($data['origen'] == 1){
            $this -> dataAsiento[] = $data['data'];    
        }else{
            $this -> dataAsiento[$data['index']] = $data['data'];
        }
        count($this->dataAsiento) !== 0 ? $this->DebeHaber($this->dataAsiento) : ($this->de = $this->ha = $this->to = 0);
        Session::put('RegistroAsiento', $this->dataAsiento);
        
    }

    #[On('PasarDeudas')]
    public function handlePasarDeudas($data){
        
        foreach($data as $dat){
            $this -> dataAsiento[] = $dat;
        }

        count($this->dataAsiento) !== 0 ? $this->DebeHaber($this->dataAsiento) : ($this->de = $this->ha = $this->to = 0);
        Session::put('RegistroAsiento', $this->dataAsiento);
        
    }

    public function EliminarFila($index){
        if (isset($this->dataAsiento[$index])) {
            unset($this->dataAsiento[$index]);
            $this->dataAsiento = array_values($this->dataAsiento); // Reindexar el array
            Session::put('RegistroAsiento', $this->dataAsiento);
            count($this->dataAsiento) !== 0 ? $this->DebeHaber($this->dataAsiento) : ($this->de = $this->ha = $this->to = 0);
        }
    }

    public function EditarFila($index){
        $this -> openForm = true;
        $traspasoEdit['origen'] = 2;
        $traspasoEdit['index'] = $index;
        $traspasoEdit['data'] = $this->dataAsiento[$index];
        $this->dispatch('EditAsiento',$traspasoEdit);

    }

    public function EstadoShow(){
        $this -> openForm = !$this -> openForm;
    }

    
    public function updatedOpenForm($value)
    {
        $estado = ($value ? 'true' : 'false');
        if ($estado == 'false') {
            $this->dispatch('resetRAsientoGeneral',$estado);
        }
    }

    public function Procesar(){
        if ($this->ValidarDatos() == 2) {
            return;
        }    
        
        if ($this-> origen == 'editar_asiento'){
            $this -> borrarAsiento();       
        }

        $dataGen = $this -> DataGeneral();
        $convencabeceras = null;
        if ($this -> conven == '1'){
            $convencabeceras = $this -> CompraVentaCabeceras();
        }
        
        foreach ($this -> dataAsiento as $Asiento){
            $this -> registroAsientoService -> insertar($dataGen,$this -> ExtraerCodigos($Asiento),$convencabeceras);
        }

        if($this -> origen == 'registrar_asiento'){
            $this -> ResetVariables();
        }else{
            session()->flash('message','Registro editado exitosamente');
        }
    }

    public function CompraVentaCabeceras(){
        $CompraVentaCabeceras = [
            'Fecha_Doc' => $this->Fecha_Doc,
            'Fecha_Ven' => $this->Fecha_Ven,
            'TDoc' => $this->TDoc,
            'Ser' => $this->Ser,
            'ADuaDsi' => $this->ADuaDsi,
            'Num' => $this->Num,
            'idt02doc' => $this->idt02doc,
            'ruc_emisor' => $this->ruc_emisor,
            'nombre_o_razon_social' => $this->nombre_o_razon_social,
            'TOpIgv' => $this->TOpIgv,
            'BasImp' => $this->BasImp,
            'IGV' => $this->IGV,
            'NoGravadas' => $this->NoGravadas,
            'ISC' => $this->ISC,
            'ImpBolPla' => $this->ImpBolPla,
            'OtroTributo' => $this->OtroTributo,
            'total' => $this->total,
            'TipCam' => $this->TipCam,
            'FechaEMod' => $this->FechaEMod,
            'TDocEMod' => $this->TDocEMod,
            'SerEMod' => $this->SerEMod,
            'CodDepenDUAoDSI' => $this->CodDepenDUAoDSI,
            'NumEMod' => $this->NumEMod,
            'FecEmiDetr' => $this->FecEmiDetr,
            'NumConstDer' => $this->NumConstDer,
            'ClasBienes' => $this->ClasBienes
        ];
        return $CompraVentaCabeceras;
    }

    public function EliminarAsiento(){
        $this -> borrarAsiento();
        return redirect()->route('empresa.lista-asiento', ['id' => $this -> empresaId]);
    }

    public function borrarAsiento(){
        Tabla::where('id_empresa', $this->empresaId)
            ->where('Mes', $this->ms)
            ->where('Libro', $this->lb)
            ->where('Vou', $this->vo)
            ->delete();
    }

    public function ResetVariables(){
        $this->reset(['mss', 'lib', 'fecha_vaucher', 'glosa', 'mon', 'de', 'ha', 'to','voucher']);
        $this->reset([
            'Fecha_Doc',
            'Fecha_Ven',
            'TDoc',
            'Ser',
            'ADuaDsi',
            'Num',
            'idt02doc',
            'ruc_emisor',
            'nombre_o_razon_social',
            'TOpIgv',
            'BasImp',
            'IGV',
            'NoGravadas',
            'ISC',
            'ImpBolPla',
            'OtroTributo',
            'total',
            'TipCam',
            'FechaEMod',
            'TDocEMod',
            'SerEMod',
            'CodDepenDUAoDSI',
            'NumEMod',
            'FecEmiDetr',
            'NumConstDer',
            'ClasBienes'
        ]);
        
        $this->dataAsiento = [];
        Session::put('RegistroAsiento', $this->dataAsiento);

    }

    public function Mpag($mpag){
        $mpags = TipoMedioDePago::where('DESCRIPCION', $mpag)->get()->first()->toarray();
        return $mpags['N'];
    }
    
    public function Tdoc($tdoc){
        $tdocs = TipoComprobantePagoDocumento::where('DESCRIPCION', $tdoc)->select('N')->get()->first()->toarray();
        return $tdocs['N'];
    }
    
    public function Estado($est){
        $estado = Estado::where('DESCRIPCION', $est)->select('N')->get()->first()->toarray();
        return $estado['N'];
    }
    
    public function Estado_doc($estdoc){
        $estdocs = EstadoDocumento::where('descripcion', $estdoc)->select('id')->get()->first()->toarray();
        return $estdocs['id'];
    }
    
    public function CC($cc, $empresaId){
        $cc = CentroDeCostos::where('id_empresa', $empresaId)->where('Descripcion', $cc)->select('id')->get()->first()->toarray();
        return $cc['id'];
    }
    
    

    public function ExtraerCodigos($Asiento){
        $Asiento['Tdoc'] = (empty($Asiento['Tdoc'])) ? null : $this -> Tdoc($Asiento['Tdoc']);
        $Asiento['Mpag'] = (empty($Asiento['Mpag'])) ? null : $this -> Mpag($Asiento['Mpag']);
        $Asiento['estado'] = (empty($Asiento['estado'])) ? null : $this -> Estado($Asiento['estado']);
        $Asiento['estado_doc'] = (empty($Asiento['estado_doc'])) ? null : $this -> Estado_doc($Asiento['estado_doc']);
        $Asiento['CC'] = (empty($Asiento['CC'])) ? null : $this -> CC($Asiento['CC'],$this->empresaId);
        return $Asiento;
    }

    public function DataGeneral(){
        $dataGen['id_empresa'] = $this -> empresaId;
        $dataGen['Mes'] = $this -> mss;
        $dataGen['Libro'] = $this -> lib;
        $dataGen['Vou'] = ($this->origen == 'editar_asiento')? $this -> vo :$this -> getVou($this -> mss, $this -> lib);
        $dataGen['Fecha_Vou'] = $this -> fecha_vaucher;
        $dataGen['GlosaGeneral'] = $this -> glosa;
        $dataGen['CodMoneda'] = $this -> mon;
        return $dataGen;
    }

    public function getVou($mes, $libro)
    {
        $lastVou = Tabla::where('Mes', $mes)
                        ->where('Libro', $libro)
                        ->orderBy('Vou', 'desc')
                        ->first(['Vou']);

        if ($lastVou) {
            return $lastVou->Vou + 1;
        }

        return 1;
    }

    public function ValidarDatos(){
        $this -> validate([
            'lib' => 'required',
            'mss' => 'required',
            'fecha_vaucher' => 'required',
            'glosa' => 'required',
            'mon' => 'required',
        ]);
        

        if (count($this -> dataAsiento) == 0){
            session()->flash('error','Tiene que haber cuentas registradas');
            return 2;
        } elseif ($this -> to <> 0){
            session()->flash('error','La diferencia tiene que ser cero');
            return 2;
        } elseif (($this -> mss * 1) <> Carbon::parse($this->fecha_vaucher)->month){
            session()->flash('error','El mes debe coincidir con la fecha');
            return 2;
        }

        return 1;
    }
        

    public function render()
    {
        return view('livewire.registrar-asiento-view')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
