<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroDeCostos extends Model
{
    use HasFactory;

     // Especifica el nombre de la tabla si no sigue la convención de nombres de Laravel
     protected $table = 'c_centrodecostos';

     // Laravel espera que las tablas tengan las columnas 'created_at' y 'updated_at'.
     // Si tu tabla no las tiene, debes desactivar su gestión automática:
     public $timestamps = false;
 
     // Especifica la clave primaria si no es 'id'
     protected $primaryKey = 'id';
 
     // Define los atributos que se pueden asignar masivamente
     protected $fillable = ['id','id_empresa','Id_cc', 'Descripcion'];
 
     // Si quieres usar la funcionalidad de asignación masiva, también deberías proteger
     // los atributos que no quieres que sean asignados masivamente:
     protected $guarded = [];
}
