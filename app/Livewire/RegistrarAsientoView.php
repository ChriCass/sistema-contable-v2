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
use App\Services\RegistroAsientoService;
use Carbon\Carbon;
use App\Models\Tabla;
use PhpParser\Node\Stmt\Return_;
use App\Models\CentroDeCostos;

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

    public function mount($id)
    {
        $this->cargardatosGenerales($id);
        $ruta = request()->segment(4);
        if ($ruta == 'registrar-asiento'){
            $this -> tipForm = 'Registro de Asiento';
        }
        $this->dataAsiento = Session::get('RegistroAsiento', []);
        count($this->dataAsiento) !== 0 ? $this->DebeHaber($this->dataAsiento) : ($this->de = $this->ha = $this->to = 0);
        
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
        $this->to = $debe - $haber;
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
        
        $dataGen = $this -> DataGeneral();
        
        foreach ($this -> dataAsiento as $Asiento){
            $this -> registroAsientoService -> insertar($dataGen,$this -> ExtraerCodigos($Asiento));
        }

        $this -> ResetVariables();

    }

    public function ResetVariables(){
        $this->reset(['mss', 'lib', 'fecha_vaucher', 'glosa', 'mon', 'de', 'ha', 'to']);
        $this->dataAsiento = [];
        Session::put('RegistroAsiento', $this->dataAsiento);

    }

    public function Mpag($mpag){
        $mpags = TipoMedioDePago::where('DESCRIPCION',$mpag)->get()->first()->toarray();
        return $mpags['N'];
    }

    public function Tdoc($tdoc){
        $tdocs = TipoComprobantePagoDocumento::where('DESCRIPCION',$tdoc)->select('N')->get()->first()->toarray();
        return $tdocs['N'];
    }

    public function Estado($est){
        $estado = Estado::where('DESCRIPCION',$est)->select('N')->get()->first()->toarray();
        return $estado['N'];
    }

    public function Estado_doc($estdoc){
        $estdocs = EstadoDocumento::where('descripcion',$estdoc)->select('id')->get()->first()->toarray();
        return $estdocs['id'];
    }

    public function CC($cc,$empresaId){
        $cc = CentroDeCostos::where('id_empresa',$empresaId)->where('Descripcion',$cc)->select('id')->get()->first()->toarray();
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
        $dataGen['Vou'] = $this -> getVou($this -> mss, $this -> lib);
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
