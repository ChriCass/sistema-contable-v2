<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoComprobantePagoDocumento extends Model
{
    use HasFactory;

    protected $table = 's_tabla10_tipodecomprobantedepagoodocumento';  // Especifica el nombre exacto de la tabla
    public $timestamps = false;  // Indica que el modelo no debe manejar automáticamente las columnas `created_at` y `updated_at`

    protected $primaryKey = 'N';  // Establece `N` como la clave primaria de la tabla
    protected $keyType = 'string';  // Define el tipo de la clave primaria
    public $incrementing = false;  // Indica que la clave primaria no es autoincremental

    protected $fillable = [
        'N', 'DESCRIPCION'  // Permite la asignación masiva en estos campos
    ];

    // No es necesario definir $guarded si $fillable está correctamente definido a menos que se necesite seguridad adicional
}
