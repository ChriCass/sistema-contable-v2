<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpIgv extends Model
{
    use HasFactory;

    protected $table = 's_opigv';  // Especifica el nombre exacto de la tabla
    public $timestamps = false;  // Indica que el modelo no debe manejar automáticamente las columnas `created_at` y `updated_at`

    protected $primaryKey = 'Id';  // Establece `Id` como la clave primaria de la tabla
    protected $keyType = 'int';  // Define el tipo de la clave primaria
    public $incrementing = true;  // Indica que la clave primaria es autoincremental

    protected $fillable = [
        'Id', 'Descripcion'  // Permite la asignación masiva en estos campos
    ];

    // No es necesario definir $guarded si $fillable está correctamente definido a menos que se necesite seguridad adicional
}
