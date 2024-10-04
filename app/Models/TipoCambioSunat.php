<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCambioSunat extends Model
{
    use HasFactory;

    protected $table = 's_tipcamsunat';  // Especifica el nombre exacto de la tabla
    public $timestamps = false;  // Indica que el modelo no debe manejar automáticamente las columnas `created_at` y `updated_at`

    protected $primaryKey = 'Id';  // Establece `Id` como la clave primaria de la tabla
    public $incrementing = true;  // Indica que la clave primaria es autoincremental

    protected $fillable = [
        'Dia', 'TipCamCompra', 'TipCamVenta'  // Permite la asignación masiva en estos campos
    ];

    // Define tipos de datos para las propiedades que no son strings para asegurar el manejo correcto de los datos
    protected $casts = [
        'Dia' => 'date', 
        'TipCamCompra' => 'float', 
        'TipCamVenta' => 'float'
    ];
}
