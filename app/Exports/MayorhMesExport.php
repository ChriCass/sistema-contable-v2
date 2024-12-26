<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class MayorhMesExport implements FromCollection
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // Cabeceras manuales según la estructura deseada
        $headings = [
            'Mes',
            'Libro',
            'Vou',
            'Cnta',
            'Descripcion',
            'Debe',
            'Haber',
            'DebeDo',
            'HaberDo',
            'TipCam',
            'GlosaEpecifica',
            'Corrent',
            'nombre_o_razon_social',
            'TDoc',
            'Ser',
            'Num',
            'N',
            'CC',
            'RefInt',
            'Estado',
            'idEstadoDoc'
        ];
        

        // Combinar las cabeceras con los datos
        return collect([
            $headings, // Añadir las cabeceras como la primera fila
            ...$this->data   // Añadir los datos a continuación
        ]);
    }
}
