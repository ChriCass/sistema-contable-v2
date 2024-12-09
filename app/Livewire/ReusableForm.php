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
    public function mount()
    {
       
        $this->idEmpresa = Session::get('EmpresaId');

       
        $idEmpresa = $this->idEmpresa->id;

        $this->CentrodeCostos = CentroDeCostos::where('id_empresa', $idEmpresa)->get();
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

    public function buscarCuenta()
{
    // Buscar la cuenta por ID y empresa
    $cuenta = PlanContable::where('id', $this->cuentaId)
        ->where('id_empresas', $this->idEmpresa->id)  // Filtrar por empresaId
        ->first();  // Usamos first() ya que buscamos una única cuenta por ID

    if ($cuenta) {
        $this->descripcionCuenta = $cuenta->Descripcion;  // Actualizar la descripción
    } else {
        $this->descripcionCuenta = 'Cuenta no encontrada';  // En caso de que no exista la cuenta
    }
}

    public function render()
    {
        return view('livewire.reusable-form');
    }
}
