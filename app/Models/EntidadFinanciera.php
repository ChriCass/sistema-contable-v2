<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadFinanciera extends Model
{
    use HasFactory;

    protected $table = 's_tabla03_entidadfinanciera';   
    public $timestamps = false; 
    protected $primaryKey = 'N';   
    protected $keyType = 'string';   
    public $incrementing = false;   

    protected $fillable = [
        'N', 'DESCRIPCION'   
    ];

}
