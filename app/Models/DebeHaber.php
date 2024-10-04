<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebeHaber extends Model
{
    use HasFactory;

     // Define el nombre de la tabla si no sigue la convención de nombres de Laravel
     protected $table = 'c_debehaber';

     // Laravel espera que las tablas tengan las columnas 'created_at' y 'updated_at'.
     // Si tu tabla no las tiene, debes desactivar su gestión automática:
     public $timestamps = false;
 
     // Define la clave primaria si no es 'id'
     protected $primaryKey = 'N';
 
     // Laravel por defecto asume que la clave primaria es un entero que se autoincrementa.
     // Establecer incrementing a true ya que N es un entero que actúa como clave primaria autoincremental.
     protected $keyType = 'int';
     public $incrementing = true;
 
     // Define los atributos que se pueden asignar masivamente
     protected $fillable = ['N', 'DESCRIPCION'];
 
     // Si quieres usar la funcionalidad de asignación masiva, también deberías proteger
     // los atributos que no quieres que sean asignados masivamente:
     protected $guarded = [];
}
