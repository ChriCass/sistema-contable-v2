<?php

namespace App\Services;

use App\Models\Tabla;
use App\Models\Libro;
use App\Models\Correntista;
use App\Models\PlanContable;
use App\Models\CentroDeCostos;
use App\Models\TipoComprobantePagoDocumento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegistroAsientoService
{
    public function insertar($dataGen,$Asiento,$convencabeceras = null){
        
        Tabla::create(['id_empresa' => $dataGen['id_empresa'],
            'Mes' => $dataGen['Mes'],
            'Libro' => $this -> libro($dataGen['Libro'],$dataGen['id_empresa']),
            'Vou' => $dataGen['Vou'],
            'Fecha_Vou' => $dataGen['Fecha_Vou'],
            'GlosaGeneral' => $dataGen['GlosaGeneral'],
            'Corrent' => (!empty($Asiento['Corrent'])) ? $this -> corrent($Asiento['Corrent'],$dataGen['id_empresa']) : null,
            'TDoc' => $Asiento['Tdoc'] ?? null,
            'Ser' => $Asiento['Ser'] ?? null,
            'Num' => $Asiento['Num'] ?? null,
            'Cnta' => $this -> cuenta($Asiento['Cnta'],$dataGen['id_empresa']),
            'DebeHaber' => (!empty($Asiento['DebeS'])) ? 1 : 2,
            'MontSoles' => (!empty($Asiento['DebeS'])) ? $Asiento['DebeS'] : $Asiento['HaberS'],
            'MontDolares' =>  null,
            'TipCam' => null,
            'GlosaEpecifica' => $Asiento['GlosaEspecifica'],
            'CC' => $Asiento['CC'],
            'TipMedioDePago' => $Asiento['Mpag'] ?? null,
            'Fecha_Doc' => $convencabeceras['Fecha_Doc'] ?? null,
            'Fecha_Ven' => $convencabeceras['Fecha_Ven'] ?? null,
            'ADuaDsi' => $convencabeceras['ADuaDsi'] ?? null,
            'TOpIgv' => $convencabeceras['TOpIgv'] ?? null,
            'BasImp' => $convencabeceras['BasImp'] ?? null,
            'IGV' => $convencabeceras['IGV'] ?? null,
            'NoGravadas' => $convencabeceras['NoGravadas'] ?? null,
            'ISC' => $convencabeceras['ISC'] ?? null,
            'ImpBolPla' => $convencabeceras['ImpBolPla'] ?? null,
            'OtroTributo' => $convencabeceras['OtroTributo'] ?? null,
            'CodMoneda' => $dataGen['CodMoneda'],
            'FechaEMod' => $convencabeceras['FechaEMod'] ?? null,
            'TDocEMod' => $convencabeceras['TDocEMod'] ?? null,
            'SerEMod' => $convencabeceras['SerEMod'] ?? null,
            'CodDepenDUAoDSI' => $convencabeceras['CodDepenDUAoDSI'] ?? null,
            'NumEMod' => $convencabeceras['NumEMod'] ?? null,
            'FecEmiDetr' => $convencabeceras['FecEmiDetr'] ?? null,
            'NumConstDer' => $convencabeceras['NumConstDer'] ?? null,
            'MarRet' => null,
            'ClasBienes' => $convencabeceras['ClasBienes'] ?? null,
            'IdenContrat' => null,
            'Err1' => null,
            'Err2' => null,
            'Err3' => null,
            'Err4' => null,
            'RefInt' => null,
            'idEstadoDoc' => $Asiento['estado_doc'] ?? null,
            'Estado' => $Asiento['estado'] ?? null,
            'Usuario' => Auth::user()->id]);
          
    }

    public function libro($libro,$empresaId){
        $lib = Libro::where('id_empresa',$empresaId)->where('N',$libro)->select('id')->get()->first()->toarray();
        return $lib['id'];
    }

    public function corrent($corrent,$empresaId){
        $corrents = Correntista::where('id_empresas',$empresaId)->where('ruc_emisor',$corrent)->select('id')->get()->first()->toarray();
        return $corrents['id'];
    }

    public function cuenta($cuenta,$empresaId){
        $cuentas = PlanContable::where('id_empresas',$empresaId)->where('CtaCtable',$cuenta)->select('id')->get()->first()->toarray();
        return $cuentas['id'];
    }


}
