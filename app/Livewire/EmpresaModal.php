<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use Exception;
use Illuminate\Support\Facades\DB;

class EmpresaModal extends Component
{
    public $openModal;
    public $anios;
    public $anio;
    public $nombre;
    public $ruc;

    public function mount()
    {
        $currentYear = now()->year;
        $this->anios = [
            $currentYear - 1,
            $currentYear,
            $currentYear + 1,
            $currentYear + 2
        ];
    }


    public function createEmpresa()
    {
        $this->validate([
            'nombre' => 'required|string|max:200',
            'anio' => 'required|max:4',
            'ruc' => 'required|size:11'
        ]);

        DB::beginTransaction();

        try {
            Empresa::create([
                'Nombre' => $this->nombre,
                'Anno' => $this->anio,
                'Ruc' => $this->ruc
            ]);

            DB::commit();

            session()->flash('success', 'Empresa creada exitosamente.');

            $this->redirect('/dashboard', navigate: true);
        } catch (Exception $e) {
            DB::rollBack();

            session()->flash('error', 'Error al crear la empresa: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.empresa-modal');
    }
}
