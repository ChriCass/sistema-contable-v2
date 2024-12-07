<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanContable extends Model
{
    use HasFactory;
      // Especifica el nombre de la tabla si no sigue la convención de nombres de Laravel
      protected $table = 'c_plancontable';

      // Desactiva la gestión automática de las columnas 'created_at' y 'updated_at'
      public $timestamps = false;
  
      // Define la clave primaria si no es 'id'
      protected $primaryKey = 'id';
  
      // Define los atributos que se pueden asignar masivamente
      protected $fillable = [
          'id','id_empresas','CtaCtable', 'Descripcion', 'Nivel', 'Dest1D', 'Dest1H', 'Dest2D', 'Dest2H',
          'Ajust79', 'Esf', 'Ern', 'Erf', 'CC', 'Libro'
      ];
  
      // Relaciones con otras tablas
      public function libro()
      {
          return $this->belongsTo(Libro::class, 'Libro', 'N');
      }
  
      // SiNo relations (assuming there's a SiNo model)
      public function ajust79()
      {
          return $this->belongsTo(SiNo::class, 'Ajust79', 'Id');
      }
  
      public function esf()
      {
          return $this->belongsTo(SiNo::class, 'Esf', 'Id');
      }
  
      public function ern()
      {
          return $this->belongsTo(SiNo::class, 'Ern', 'Id');
      }
  
      public function erf()
      {
          return $this->belongsTo(SiNo::class, 'Erf', 'Id');
      }
  
      public function cc()
      {
          return $this->belongsTo(SiNo::class, 'CC', 'Id');
      }
}
