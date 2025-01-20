<?php
namespace App\Services;

use App\Models\PlanContable;

class PlanContableService
{
    
    public function getCuentasByEmpresaId(int $empresaId)
    {
        return PlanContable::where('id_empresas', $empresaId)->get();
    }

    /**
     * Verificar si una empresa tiene cuentas contables.
     *
     * @param int $empresaId
     * @return bool
     */
    public function hasCuentas(int $empresaId): bool
    {
        return PlanContable::where('id_empresas', $empresaId)->exists();
    }

    /**
     * Crear una nueva cuenta contable.
     *
     * @param array $data
     * @return \App\Models\PlanContable
     */
    public function createCuenta(array $data): PlanContable
    {
        return PlanContable::create($data);
    }

    /**
     * Actualizar una cuenta contable existente.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateCuenta(int $id, array $data): bool
    {
        $cuenta = PlanContable::findOrFail($id);
        return $cuenta->update($data);
    }

     /**
     * Obtener una cuenta contable por su ID y empresa ID.
     *
     * @param int $id
     * @param int $empresaId
     * @return \App\Models\PlanContable
     */
    public function getCuentaById(int $id, int $empresaId): PlanContable
    {
        return PlanContable::where('id', $id)->where('id_empresas', $empresaId)->firstOrFail();
    }

    /**
     * Eliminar una cuenta contable.
     *
     * @param int $id
     * @return bool
     */
    public function deleteCuenta(int $id): bool
    {
        $cuenta = PlanContable::findOrFail($id);
        return $cuenta->delete();
    }
}