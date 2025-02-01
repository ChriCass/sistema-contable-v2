<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use App\Models\Mes;
use App\Models\PlanContable;
use App\Services\PlanContableService;

class PlanContableGenForm extends Component
{
    public $empresa;
    public $empresaId;
    public $result;
    public $meses;
    public $showCard = false;

    // Nuevas variables públicas para los inputs
    public $id_empresas;
    public $CtaCtable;
    public $Descripcion;
    public $Nivel;
    public $Dest1D;
    public $Dest1H;
    public $Dest2D;
    public $Dest2H;
    public $Ajust79;
    public $Esf;
    public $Ern;
    public $Erf;
    public $CC;
    public $Libro;
    public $origen;
    public $CtaCtableEdit;
    public $SiNo;

    protected  $PlanContableService;
    public function mount($id)
    {
        $this->initialData();
        $this->origen = request()->get('origen', 'ingreso');
        $this->CtaCtableEdit = request()->get('CtaCtableEdit', '');
        if ($this->origen == 'edit') {
            $this->loadCuentaData($this->CtaCtableEdit);
        }
        $this->empresa = Empresa::findOrFail($id);
        $this->empresaId = $this->empresa->id;
    }

    public function loadCuentaData($CtaCtable)
    {
        $Cuenta = PlanContable::where('id', $CtaCtable)->first();

        if ($Cuenta) {
            $this->CtaCtable = $Cuenta->CtaCtable;
            $this->Descripcion = $Cuenta->Descripcion;
            $this->Nivel = $Cuenta->Nivel;
            $this->Dest1D = $Cuenta->Dest1D;
            $this->Dest1H = $Cuenta->Dest1H;
            $this->Dest2D = $Cuenta->Dest2D;
            $this->Dest2H = $Cuenta->Dest2H;
            $this->Ajust79 = $Cuenta->Ajust79;
            $this->Esf = $Cuenta->Esf;
            $this->Ern = $Cuenta->Ern;
            $this->Erf = $Cuenta->Erf;
            $this->CC = $Cuenta->CC;
            $this->Libro = $Cuenta->Libro;
        }
    }

    public function hydrate(PlanContableService $PlanContableService)
    {
        $this->PlanContableService = $PlanContableService;
    }

    public function UpdatePlanContable($id)
    {
        $this->validate([
            'CtaCtable' => 'required|max:15',
            'Descripcion' => 'required|max:255',
            'Nivel' => 'required|integer',
            'Ajust79' => 'required|max:1',
            'Esf' => 'required|max:1',
            'Ern' => 'required|max:1',
            'Erf' => 'required|max:1',
            'CC' => 'required|max:1',
        ]);

        $data = [
            'id_empresas' => $this->empresaId,
            'CtaCtable' => $this->CtaCtable,
            'Descripcion' => $this->Descripcion,
            'Nivel' => $this->Nivel,
            'Dest1D' => $this->Dest1D,
            'Dest1H' => $this->Dest1H,
            'Dest2D' => $this->Dest2D,
            'Dest2H' => $this->Dest2H,
            'Ajust79' => $this->Ajust79,
            'Esf' => $this->Esf,
            'Ern' => $this->Ern,
            'Erf' => $this->Erf,
            'CC' => $this->CC,
            'Libro' => $this->Libro,
        ];

 
       
        try {
            $this->PlanContableService->updateCuenta($id, $data);
            session()->flash('success', 'Plan contable actualizado exitosamente.');
          return  $this->redirect(route('empresa.plan-contable', ['id' => $this->empresaId]), navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un error al actualizar el plan contable: ' . $e->getMessage());
        }
    }

    public function CreatePlanContable()
    {
        $this->validate([
            'CtaCtable' => 'required|max:15',
            'Descripcion' => 'required|max:200',
            'Nivel' => 'required|integer',
            'Ajust79' => 'required|max:1',
            'Esf' => 'required|max:1',
            'Ern' => 'required|max:1',
            'Erf' => 'required|max:1',
            'CC' => 'required|max:1',
        ]);

        $data = [
            'id_empresas' => $this->empresaId,
            'CtaCtable' => $this->CtaCtable,
            'Descripcion' => $this->Descripcion,
            'Nivel' => $this->Nivel,
            'Dest1D' => $this->Dest1D,
            'Dest1H' => $this->Dest1H,
            'Dest2D' => $this->Dest2D,
            'Dest2H' => $this->Dest2H,
            'Ajust79' => $this->Ajust79,
            'Esf' => $this->Esf,
            'Ern' => $this->Ern,
            'Erf' => $this->Erf,
            'CC' => $this->CC,
            'Libro' => $this->Libro,
        ];

        if (empty(array_filter($data))) {
            session()->flash('warning', 'No se creó nada.');
            return;
        }

        try {
            $this->PlanContableService->createCuenta($data);
            session()->flash('success', 'Plan contable creado exitosamente.');
            $this->redirect(route('empresa.plan-contable', ['id' => $this->empresaId]), navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un error al crear el plan contable: ' . $e->getMessage());
        }
    }


    public function initialData()
    {
        $this->meses = Mes::all();
        $this->SiNo = [
            ['id' => 'S', 'descripcion' => 'Si'],
            ['id' => 'N', 'descripcion' => 'No']
        ];
    }
    public function render()
    {
        return view('livewire.plan-contable-gen-form')->layout('layouts.app', ['empresa' => $this->empresa]);
    }
}
