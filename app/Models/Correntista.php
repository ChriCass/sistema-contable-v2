<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correntista extends Model
{
    use HasFactory;

    protected $table = 'g_conrrentistas';
    public $timestamps = false;  // Asumiendo que la tabla no tiene timestamps
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id','id_empresas','ruc_emisor', 'nombre_o_razon_social', 'estado_del_contribuyente',
        'condicion_de_domicilio', 'ubigeo', 'tipo_de_via', 'nombre_de_via',
        'codigo_de_zona', 'tipo_de_zona', 'numero', 'interior', 'lote', 'dpto',
        'manzana', 'kilometro', 'distrito', 'provincia', 'departamento',
        'direccion_simple', 'direccion', 'idt02doc'
    ];

    // Lista de atributos que no deben ser asignados masivamente
    protected $guarded = [];
}
