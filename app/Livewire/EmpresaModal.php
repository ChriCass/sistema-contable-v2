<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use App\Models\Libro;
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
            // Crear la empresa
            $empresa = Empresa::create([
                'Nombre' => $this->nombre,
                'Anno' => $this->anio,
                'Ruc' => $this->ruc
            ]);
    
            // Libros predeterminados
            $librosPredeterminados = [
                ['id_empresa' => $empresa->id, 'N' => '00', 'DESCRIPCION' => 'APERTURA'],
                ['id_empresa' => $empresa->id, 'N' => '01', 'DESCRIPCION' => 'COMPRAS'],
                ['id_empresa' => $empresa->id, 'N' => '02', 'DESCRIPCION' => 'VENTAS'],
                ['id_empresa' => $empresa->id, 'N' => '03', 'DESCRIPCION' => 'CAJA Y BANCOS'],
                ['id_empresa' => $empresa->id, 'N' => '05', 'DESCRIPCION' => 'DIARIO'],
                ['id_empresa' => $empresa->id, 'N' => '06', 'DESCRIPCION' => 'APLICACIONES'],
            ];
    
            // Insertar los libros predeterminados usando el modelo Libro
            Libro::insert($librosPredeterminados);
    
            DB::commit();
    
            session()->flash('success', 'Empresa y libros predeterminados creados exitosamente.');
    
            $this->redirect('/dashboard', navigate: true);
        } catch (Exception $e) {
            DB::rollBack();
    
            session()->flash('error', 'Error al crear la empresa y los libros: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.empresa-modal');
    }
}
