<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabla extends Model
{
    use HasFactory;
    protected $table = 'c_tabla';
    public $timestamps = false;  // Asumiendo que la tabla no tiene timestamps
    protected $primaryKey = 'Id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'id_empresa', 'Mes', 'Libro', 'Vou', 'Fecha_Vou', 'GlosaGeneral', 'Corrent', 
        'TDoc', 'Ser', 'Num', 'Cnta', 'DebeHaber', 'MontSoles', 'MontDolares', 
        'TipCam', 'GlosaEpecifica', 'CC', 'TipMedioDePago', 'Fecha_Doc', 'Fecha_Ven', 
        'ADuaDsi', 'TOpIgv', 'BasImp', 'IGV', 'NoGravadas', 'ISC', 'ImpBolPla', 'OtroTributo', 
        'CodMoneda', 'FechaEMod', 'TDocEMod', 'SerEMod', 'CodDepenDUAoDSI', 'NumEMod', 
        'FecEmiDetr', 'NumConstDer', 'MarRet', 'ClasBienes', 'IdenContrat', 
        'Err1', 'Err2', 'Err3', 'Err4', 'RefInt', 'idEstadoDoc', 'Estado', 'Usuario'
    ];

    // Relaciones con otras tablas
    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa', 'id_empresa');
    }

    public function libro()
    {
        return $this->belongsTo('App\Models\Libro', 'Libro', 'N');
    }

    public function debeHaber()
    {
        return $this->belongsTo('App\Models\DebeHaber', 'DebeHaber', 'N');
    }

    public function estado()
    {
        return $this->belongsTo('App\Models\Estado', 'Estado', 'N');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'Usuario', 'Id');
    }
}
