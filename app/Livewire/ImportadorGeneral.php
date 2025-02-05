<?php

namespace App\Livewire;
use App\Models\Empresa;
use Livewire\Component;
use App\Models\PlanContable;
use Livewire\WithFileUploads;
use App\Exports\PlanContableExport;
use App\Imports\PlanContableImport;
use App\Services\PlanContableService;
use Maatwebsite\Excel\Facades\Excel;
class ImportadorGeneral extends Component
{
    public $origen;
    public $empresa;
    public $empresaId;
    public $data;
    public $excelFile;

    use WithFileUploads;
    public function mount($id)
    {

        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
       
    }

    public function procesar()
    {
        $this->validate([
            'excelFile' => 'required|mimes:xls,xlsx|max:10240', // 10MB máximo
        ]);

        // Importar el archivo Excel
        Excel::import(
            new PlanContableImport($this->empresaId, new PlanContableService()),
            $this->excelFile
        );

        session()->flash('message', 'Archivo procesado correctamente.');
    }


    public function checkingCuentas($empresaId)
    {
        $cuentas = PlanContable::where('id_empresas', $empresaId)->exists();
        return $cuentas;
    }

    public function downloadExcel()
    {
        // Genera el archivo Excel y lo descarga
        return Excel::download(new PlanContableExport(), 'plan_contable.xlsx');
    }
    public function render()
    {
        return view('livewire.importador-general')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
