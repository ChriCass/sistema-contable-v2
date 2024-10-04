<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeRenta extends Model
{
    use HasFactory;

    protected $table = 's_tabla31_tipoderenta';  // Especifica el nombre exacto de la tabla
    public $timestamps = false;  // Indica que el modelo no debe manejar automáticamente las columnas `created_at` y `updated_at`

    protected $primaryKey = 'N';  // Establece `N` como la clave primaria de la tabla
    protected $keyType = 'string';  // Define el tipo de la clave primaria
    public $incrementing = false;  // Indica que la clave primaria no es autoincremental

    protected $fillable = [
        'N', 'DESCRIPCION', 'ArtDeLaLIR', 'CodigoRenOCDE'  // Permite la asignación masiva en estos campos
    ];
}
