<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mes extends Model
{
    use HasFactory;

    protected $table = 'g_meses';  
    public $timestamps = false;  

    protected $primaryKey = 'N'; 
    protected $keyType = 'string'; 
    public $incrementing = false;  

    protected $fillable = [
        'N', 'MES'  
    ];

  
}
