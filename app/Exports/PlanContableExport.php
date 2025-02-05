<?php

namespace App\Exports;

use App\Models\PlanContable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PlanContableExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        // Retorna un array vacío para que no haya datos, solo cabeceras
        return [];
    }

    public function headings(): array
    {
        // Define las cabeceras personalizadas
        return [
            'CtaCtable',      // varchar(15)
            'Descripcion',    // varchar(200)
            'Nivel',          // int
            'Dest1D',         // varchar(15)
            'Dest1H',         // varchar(15)
            'Dest2D',         // varchar(15)
            'Dest2H',         // varchar(15)
            'Ajust79',        // varchar(1)
            'Esf',            // varchar(1)
            'Ern',            // varchar(1)
            'Erf',            // varchar(1)
            'CC',             // varchar(1)
            'Libro'           // int
        ];
    }
}