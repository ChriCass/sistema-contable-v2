<?php

namespace App\Imports;

use App\Models\PlanContable;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Services\PlanContableService;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Para usar las cabeceras como claves del array
class PlanContableImport implements ToModel, WithHeadingRow
{ protected $empresaId;
    protected $planContableService;

    public function __construct(int $empresaId, PlanContableService $planContableService)
    {
        $this->empresaId = $empresaId;
        $this->planContableService = $planContableService;
    }

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Mapear las columnas del Excel a los campos del modelo
        $data = [
            'id_empresas' => $this->empresaId,       // ID de la empresa
            'CtaCtable'   => $row['ctactable'],      // varchar(15)
            'Descripcion' => $row['descripcion'],    // varchar(200)
            'Nivel'       => $row['nivel'],          // int
            'Dest1D'      => $row['dest1d'],         // varchar(15)
            'Dest1H'      => $row['dest1h'],         // varchar(15)
            'Dest2D'      => $row['dest2d'],         // varchar(15)
            'Dest2D'      => $row['dest2h'],         // varchar(15)
            'Ajust79'     => $row['ajust79'],        // varchar(1)
            'Esf'         => $row['esf'],            // varchar(1)
            'Ern'         => $row['ern'],            // varchar(1)
            'Erf'         => $row['erf'],            // varchar(1)
            'CC'          => $row['cc'],             // varchar(1)
            'libro'       => $row['libro'],          // int

        ];

        // Usar el servicio para crear la cuenta contable
        return $this->planContableService->createCuenta($data);
    }
}
