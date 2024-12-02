<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PlantillaExport implements WithHeadings, WithStyles
{
    /**
     * Define los encabezados.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Libro', 'Fecha_Registo', 'Fecha_Doc', 'Fecha_Ven', 'tdoc', 'Corrent', 'Raz Social', 'TDoc', 'Ser', 'Num', 'CodMoneda', 'TipCam', 'TOpIgv', 'BasImp', 'IGV', 'NoGravadas', 'ISC', 'ImpBolPla', 'OtroTributo', 'Precio', 'Glosa', 'Cnta1', 'Cnta2', 'Cnta3', 'CntaPrecio', 'Mon1', 'Mon2', 'Mon3', 'CC1', 'CC2', 'CC3', 'CtaOtroT', 'FechaEMod', 'TDocEMod', 'SerEMod', 'NumEMod', 'FecEmiDetr', 'NumConstDer', 'TieneDetracc', 'CtaDetracc', 'MontDetracc', 'RefInt1', 'RefInt2', 'RefInt3', 'EstadoDoc', 'Estado'
        ];
    }

    /**
     * Aplica estilos a las celdas.
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Aplica negrita a la primera fila (encabezados)
            1 => ['font' => ['bold' => true]],
        ];
    }
}