<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\PlanContable;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Session;

class CuadroDeCuentas extends Component
{
    public $openModal = false;
    public $cuenta;
    public $planContable;
    public $seleccionados = 2;
    public $selector;
    public $cuentaTraspaso;
    public $empresaId;

    #[On('ModalCuentas')]
    public function handleModalCuentas($modal)
    {
        $this -> openModal = $modal['modal'];  
        $this -> cuentaTraspaso = $modal['traspaso']; 
        $this -> empresaId = Session::get('EmpresaId');
    }

    public function seleccionar($id)
    {
        $this->selector = $id;   
    }

    public function updatedcuenta($value){
        if (strlen($value) >= 2){
            $this -> planContable = PlanContable::where('CtaCtable', 'like', '%' . $value . '%')
                ->orWhere('Descripcion', 'like', '%' . $value . '%')
                ->where('id_empresas',$this->empresaId['id'])
                ->get();
        } else {
            $this -> planContable = null;
        }
        $this->selector = null;
    }

    public function submit(){
        if(!empty($this->selector)){
            $this->openModal = false;   
            $traspado = $this->planContable[($this->selector - 1)];
            if ($this -> cuentaTraspaso == 1){
                $this->dispatch('TraspasoCnta1', $traspado);
            } elseif ($this -> cuentaTraspaso == 2){
                $this->dispatch('TraspasoCnta2', $traspado);
            } elseif ($this -> cuentaTraspaso == 3){
                $this->dispatch('TraspasoCnta3', $traspado);
            } elseif ($this -> cuentaTraspaso == 4){
                $this->dispatch('TraspasoCntaPrecio', $traspado);
            } elseif ($this -> cuentaTraspaso == 5){
                $this->dispatch('Traspasocta_otro_t', $traspado);
            } elseif ($this -> cuentaTraspaso == 6){
                $this->dispatch('cta_detracc', $traspado);
            } elseif ($this -> cuentaTraspaso == 7){
                $this->dispatch('EdTraspasoCnta1', $traspado);
            } elseif ($this -> cuentaTraspaso == 8){
                $this->dispatch('EdTraspasoCnta2', $traspado);
            } elseif ($this -> cuentaTraspaso == 9){
                $this->dispatch('EdTraspasoCnta3', $traspado);
            } elseif ($this -> cuentaTraspaso == 10){
                $this->dispatch('EdTraspasoCntaPrecio', $traspado);
            } elseif ($this -> cuentaTraspaso == 11){
                $this->dispatch('EdTraspasocta_otro_t', $traspado);
            } elseif ($this -> cuentaTraspaso == 12){
                $this->dispatch('Edcta_detracc', $traspado);
            } 
        }else{
            session()->flash('error', 'Elige una cuenta.');
        }
    }

    public function render()
    {
        return view('livewire.cuadro-de-cuentas');
    }
}
