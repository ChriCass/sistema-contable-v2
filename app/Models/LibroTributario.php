<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibroTributario extends Model
{
    use HasFactory;

    protected $table = 's_librostributarios_agrcts';  
    public $timestamps = false;  

    protected $primaryKey = 'N'; 
    protected $keyType = 'int';  
    public $incrementing = false;  
    protected $fillable = [
        'N', 'Descripcion'  
    ];

  
}
