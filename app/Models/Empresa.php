<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{   
    use HasFactory;

    // Define la tabla asociada al modelo
    protected $table = 'g_empresas';

    // Indica que el id es autoincremental
    protected $primaryKey = 'id';

    // Indica que el id es de tipo entero
    protected $keyType = 'int';

    // Si la tabla usa timestamps (created_at, updated_at), déjalo como true. Si no, cámbialo a false
    public $timestamps = false;

    // Define los campos que pueden ser asignados de forma masiva
    protected $fillable = [
        'Nombre',
        'Anno',
        'Ruc'
    ];
}
