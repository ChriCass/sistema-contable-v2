<?php

namespace App\Livewire;

use App\Services\PlanContableService;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Models\PlanContable;
use Illuminate\Support\Facades\Log;

class DeletePlanContableModal extends ModalComponent
{
    public $openModal = false;
    protected  $PlanContableService;
    public $CtaCtableId;
    public $cuenta;
    public $empresaId;
    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function hydrate(PlanContableService $PlanContableService)
    {
        $this->PlanContableService = $PlanContableService;
    }

    public function mount($CtaCtableId, $id)
    {
        $this->empresaId = $id;
        $this->CtaCtableId = $CtaCtableId;
        $this->cuenta = PlanContable::findOrFail($CtaCtableId);
    }

    public function deleteCuenta()
    {
        try {
            // Log para verificar la entrada al método
            Log::info('deleteCuenta ejecutado', ['CtaCtableId' => $this->CtaCtableId]);

            // Log para verificar si el servicio se está invocando
            Log::info('Intentando eliminar cuenta contable', ['CtaCtableId' => $this->CtaCtableId]);

            $this->PlanContableService->deleteCuenta($this->CtaCtableId);

            // Log para confirmar que la cuenta fue eliminada correctamente
            Log::info('Cuenta contable eliminada exitosamente', ['CtaCtableId' => $this->CtaCtableId]);

            session()->flash('success', 'Cuenta contable eliminada exitosamente.');
            return $this->redirect(route('empresa.plan-contable', ['id' => $this->empresaId]), navigate: true);
        } catch (\Exception $e) {
            // Log del error capturado
            Log::error('Error al eliminar la cuenta contable', [
                'CtaCtableId' => $this->CtaCtableId,
                'error' => $e->getMessage()
            ]);

            session()->flash('error', 'Hubo un error al eliminar la cuenta contable: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.delete-plan-contable-modal');
    }
}
