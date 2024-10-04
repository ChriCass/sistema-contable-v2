<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    
    // Especifica el nombre de la tabla si no sigue la convención de nombres de Laravel
    protected $table = 'c_estado';

    // Desactiva la gestión automática de las columnas 'created_at' y 'updated_at'
    public $timestamps = false;

    // Define la clave primaria si no es 'id'
    protected $primaryKey = 'N';

    // Establecer el tipo de clave primaria y si se autoincrementa
    protected $keyType = 'int';
    public $incrementing = true;

    // Define los atributos que se pueden asignar masivamente
    protected $fillable = ['N', 'DESCRIPCION'];

    // Lista de atributos que no deben ser asignados masivamente
    protected $guarded = [];


}
