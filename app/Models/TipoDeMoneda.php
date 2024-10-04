<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeMoneda extends Model
{
    use HasFactory;

    protected $table = 's_tabla04_tipodemoneda';  
    public $timestamps = false;  

    protected $primaryKey = 'COD';  
    protected $keyType = 'string';  
    public $incrementing = false;  

    protected $fillable = [
        'COD', 'DESCRIPCION', 'PAISOZONAR'  
    ];

    
}
