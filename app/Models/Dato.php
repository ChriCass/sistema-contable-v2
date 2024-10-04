<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dato extends Model
{
    use HasFactory;

    protected $table = 'g_datos';
    public $timestamps = false;  // Si la tabla no maneja timestamps, desactivarlos aquí
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'Clave'
    ];

    // No hay necesidad de definir $guarded si $fillable está bien definido
}
