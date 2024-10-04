<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoDocumento extends Model
{
    use HasFactory;

    protected $table = 'g_estadodocumento';  
    public $timestamps = false;  

    protected $primaryKey = 'id';  
    protected $keyType = 'int';  
    public $incrementing = true;  

    protected $fillable = [
        'descripcion'  
    ];

    
}
