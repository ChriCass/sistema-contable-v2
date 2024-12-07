<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CentroDeCostos;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ModalCentroDeCostos extends Component
{
    public $openModal = false;
    public $cuenta;
    public $centroDeCostos;
    public $seleccionados = 2;
    public $selector;
    public $CCTraspaso;

    // Usamos '@On' para escuchar el evento 'ModalCC'
    #[On('CentroCostos')]
    public function handleCentroCostos($modal)
    {
        $IdEmpresa = Session::get('EmpresaId');
        $this -> openModal = $modal['modal'];  
        $this -> CCTraspaso = $modal['traspaso']; 
        $this -> centroDeCostos = CentroDeCostos::where('id_empresa',$IdEmpresa['id'])->get();
    }



    public function seleccionar($id)
    {
        $this->selector = $id;   
    }

    public function submit(){
        if(!empty($this->selector)){
            $this->openModal = false;   
            $traspado = $this->centroDeCostos[($this->selector - 1)];
            if ($this -> CCTraspaso == 1){
                $this->dispatch('TraspasoCC1', $traspado);
            } elseif ($this -> CCTraspaso == 2){
                $this->dispatch('TraspasoCC2', $traspado);
            } elseif ($this -> CCTraspaso == 3){
                $this->dispatch('TraspasoCC3', $traspado);
            }elseif ($this -> CCTraspaso == 4){
                $this->dispatch('EdTraspasoCC1', $traspado);
            }elseif ($this -> CCTraspaso == 5){
                $this->dispatch('EdTraspasoCC2', $traspado);
            }elseif ($this -> CCTraspaso == 6){
                $this->dispatch('EdTraspasoCC3', $traspado);
            }
   
        }else{
            session()->flash('error', 'Elige una cuenta.');
        }
    }
    public function render()
    {
        return view('livewire.modal-centro-de-costos');
    }
}
