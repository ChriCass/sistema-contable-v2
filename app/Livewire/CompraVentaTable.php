<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use App\Models\Empresa;
use App\Models\Libro;
use App\Models\OpIgv;
use App\Models\EstadoDocumento;
use App\Models\TipoComprobantePagoDocumento;
use App\Models\Estado;
use App\Models\Tabla;
use App\Models\Correntista;
use App\Models\PlanContable;
use App\Models\CentroDeCostos;
use Exception;
use Illuminate\Support\Facades\Session;

class CompraVentaTable extends Component
{   
    public $data = [];
    public $montoDolares = [];
    public $empresa;
    public $rows = [];
    public $libros, $opigvs, $estado_docs, $estados, $ComprobantesPago;
    public $statusMessage;
    public $statusType;

  

    #[On('dataSubmitted')]
    public function handleDataSubmitted($data)
    {
        $this->data[] = $data; // Acumular los datos en lugar de reemplazarlos
        Session::put('compraVentaData', $this->data); // Almacenar en la sesión
        Log::info('Data received in CompraVentaTable: ', $this->data);
    }
    #[On('dataUpdated')]
    public function handleDataUpdated($data)
    {
        $this->data[$data['index']] = $data['data']; // Actualizar los datos en lugar de reemplazarlos
        Session::put('compraVentaData', $this->data); // Actualizar en la sesión
        Log::info('Data updated in CompraVentaTable: ', $this->data);
    }
    #[On('montoDolaresGuardado')]
    public function handleMontoDolaresGuardado($data)
    {
        $this->montoDolares = $data;
        Log::info('Data received in CompraVentaTable: ', $this->montoDolares);
    }

    public function mount()
    {
        $this->empresa = Empresa::find(1);
        $this->libros = Libro::all();
        $this->opigvs = Opigv::all();
        $this->estado_docs = EstadoDocumento::all();
        $this->estados = Estado::all();
        $this->ComprobantesPago = TipoComprobantePagoDocumento::all();

        // Recuperar datos de la sesión si existen
        $this->data = Session::get('compraVentaData', []);
    }

    public function NoMoreRow($index)
    {
        if (isset($this->data[$index])) {
            unset($this->data[$index]);
            $this->data = array_values($this->data); // Reindexar el array
            Session::put('compraVentaData', $this->data);
        }
    }

    public function editRow($index)
    {
        $this->dispatch('loadData', ['index' => $index, 'data' => $this->data[$index]]);

        $this->dispatch('openModal');
    }
    
    public function insertData()
    {
        Log::info('Starting batch data insertion');
        DB::beginTransaction(); // Iniciar la transacción
    
        try {
            foreach ($this->data as $index) {
                // Verificar que el item existe antes de proceder

                $mov = $this -> getVou($index['fecha_vaucher'],$index['libro']);
                if ($index['libro'] == '01'){
                    if($index['tdoc'] <> '07'){
                        foreach(['cnta1','cnta2','cnta3'] as $cnta){
                            if(!empty($index[$cnta])){
                                //Log::info($index[$cnta]);
                                $this -> insertIntoTabla($mov,$index,$index[$cnta]);
                                if(!empty($index[$cnta."_destinos"])){
                                    foreach($index[$cnta."_destinos"] as $destino){
                                        $this -> insertIntoTabla($mov,$index,$destino);
                                    }  
                                }
                            }
                        }
                        $this -> insertIntoTabla($mov,$index,$index['cuenta_igv']);
                        if(!empty($index['cta_otro_t']['cuenta'])){
                            $this -> insertIntoTabla($mov,$index,$index['cta_otro_t']);
                        }
                        $this -> insertIntoTabla($mov,$index,$index['cnta_precio']);
                        if(!empty($index['cta_detracc']['cuenta'])){
                            $this -> insertIntoTabla($mov,$index,$index['cta_detracc']);
                        }
                    }else{
                        $this -> insertIntoTabla($mov,$index,$index['cnta_precio']);
                        if(!empty($index['cta_detracc']['cuenta'])){
                            $this -> insertIntoTabla($mov,$index,$index['cta_detracc']);
                        }
                        $this -> insertIntoTabla($mov,$index,$index['cuenta_igv']);
                        if(!empty($index['cta_otro_t']['cuenta'])){
                            $this -> insertIntoTabla($mov,$index,$index['cta_otro_t']);
                        }
                        foreach(['cnta1','cnta2','cnta3'] as $cnta){
                            if(!empty($index[$cnta])){
                                //Log::info($index[$cnta]);
                                $this -> insertIntoTabla($mov,$index,$index[$cnta]);
                                if(!empty($index[$cnta."_destinos"])){
                                    foreach($index[$cnta."_destinos"] as $destino){
                                        $this -> insertIntoTabla($mov,$index,$destino);
                                    }  
                                }
                            }
                        }
                    }
                }else{// libro '02'
                    if($index['tdoc'] <> '07'){
                        $this -> insertIntoTabla($mov,$index,$index['cnta_precio']);
                        if(!empty($index['cta_detracc']['cuenta'])){
                            $this -> insertIntoTabla($mov,$index,$index['cta_detracc']);
                        }
                        $this -> insertIntoTabla($mov,$index,$index['cuenta_igv']);
                        if(!empty($index['cta_otro_t']['cuenta'])){
                            $this -> insertIntoTabla($mov,$index,$index['cta_otro_t']);
                        }
                        foreach(['cnta1','cnta2','cnta3'] as $cnta){
                            if(!empty($index[$cnta])){
                                //Log::info($index[$cnta]);
                                $this -> insertIntoTabla($mov,$index,$index[$cnta]);
                                if(!empty($index[$cnta."_destinos"])){
                                    foreach($index[$cnta."_destinos"] as $destino){
                                        $this -> insertIntoTabla($mov,$index,$destino);
                                    }  
                                }
                            }
                        }
                    }else{
                        foreach(['cnta1','cnta2','cnta3'] as $cnta){
                            if(!empty($index[$cnta])){
                                //Log::info($index[$cnta]);
                                $this -> insertIntoTabla($mov,$index,$index[$cnta]);
                                if(!empty($index[$cnta."_destinos"])){
                                    foreach($index[$cnta."_destinos"] as $destino){
                                        $this -> insertIntoTabla($mov,$index,$destino);
                                    }  
                                }
                            }
                        }
                        $this -> insertIntoTabla($mov,$index,$index['cuenta_igv']);
                        if(!empty($index['cta_otro_t']['cuenta'])){
                            $this -> insertIntoTabla($mov,$index,$index['cta_otro_t']);
                        }
                        $this -> insertIntoTabla($mov,$index,$index['cnta_precio']);
                        if(!empty($index['cta_detracc']['cuenta'])){
                            $this -> insertIntoTabla($mov,$index,$index['cta_detracc']);
                        }
                    }
                }

                
            }
    
            // Reindexar el array y actualizar la sesión después de eliminar los elementos insertados
            $this->data = array_values($this->data);
            Session::put('compraVentaData', $this->data);
    
            DB::commit(); // Confirmar la transacción
            Log::info('Data insertion completed successfully');
            $this->statusMessage = "Data inserted successfully!";
            $this->statusType = 'success';
        } catch (Exception $e) {
            DB::rollBack(); // Revertir la transacción si hay un error
            Log::error('Data insertion failed', ['error' => $e->getMessage()]);
            $this->statusMessage = 'Error al insertar los datos: ' . $e->getMessage();
            $this->statusType = 'danger';
        }
    }
    

    private function getVou($fechaDoc, $libro)
    {
        $mes = date('m', strtotime($fechaDoc));

        $lastVou = Tabla::where('Mes', $mes)
                        ->where('Libro', $libro)
                        ->orderBy('Vou', 'desc')
                        ->first(['Vou']);

        if ($lastVou) {
            return $lastVou->Vou + 1;
        }

        return 1;
    }


    private function insertIntoTabla($mov,$data,$cuenta)
    {
        Log::info('Inserting into Tabla', ['data' => $data]);
        
        $array = [
            'id_empresa' => $data['empresa'],
            'Mes' => $data['fecha_vaucher'] ? date('m', strtotime($data['fecha_vaucher'])) : null,
            'Libro' => $data['libro'] ?? null,
            'Vou' => $mov ?? null,
            'Fecha_Vou' => $data['fecha_vaucher'] ?? null,
            'GlosaGeneral' => isset($data['glosa']) ? strtoupper($data['glosa']) : null,
            'Corrent' => $data['correntistaData']['dni'] ?? $data['correntistaData']['ruc_emisor'] ?? null,
            'TDoc' => $data['tdoc'] ?? null,
            'Ser' => $data['ser'] ?? null,
            'Num' => $data['num'] ?? null,
            'Cnta' => $cuenta['cuenta'] ?? null,
            'DebeHaber' => $cuenta['DebeHaber'] ?? null,
            'MontSoles' => $cuenta['monto'] ?? $cuenta['precioTotal'] ?? null,
            'MontDolares' =>  null,
            'TipCam' => $data['TipCam'] ?? null,
            'GlosaEpecifica' => isset($data['GlosaEpecifica']) ? strtoupper($data['GlosaEpecifica']) : (isset($data['glosa']) ? strtoupper($data['glosa']) : null),
            'CC' => $cuenta['CC'] ?? null,
            'TipMedioDePago' => $data['TipMedioDePago'] ?? null,
            'Fecha_Doc' => $data['fecha_doc'] ?? null,
            'Fecha_Ven' => $data['fecha_ven'] ?? null,
            'ADuaDsi' => $data['ADuaDsi'] ?? null,
            'TOpIgv' => $data['opigv'] ?? null,
            'BasImp' => $data['bas_imp'] ?? null,
            'IGV' => $data['igv'] ?? null,
            'NoGravadas' => $data['NoGravadas'] ?? null,
            'ISC' => $data['ISC'] ?? null,
            'ImpBolPla' => $data['ImpBolPla'] ?? null,
            'OtroTributo' => $data['OtroTributo'] ?? null,
            'CodMoneda' => $data['cod_moneda'] ?? null,
            'FechaEMod' => $data['fecha_emod'] ?? null,
            'TDocEMod' => $data['tdoc_emod'] ?? null,
            'SerEMod' => $data['ser_emod'] ?? null,
            'CodDepenDUAoDSI' => $data['CodDepenDUAoDSI'] ?? null,
            'NumEMod' => $data['num_emod'] ?? null,
            'FecEmiDetr' => $data['fec_emi_detr'] ?? null,
            'NumConstDer' => $data['num_const_der'] ?? null,
            'MarRet' => $data['MarRet'] ?? null,
            'ClasBienes' => $data['ClasBienes'] ?? null,
            'IdenContrat' => $data['IdenContrat'] ?? null,
            'Err1' => $data['Err1'] ?? null,
            'Err2' => $data['Err2'] ?? null,
            'Err3' => $data['Err3'] ?? null,
            'Err4' => $data['Err4'] ?? null,
            'RefInt' => $cuenta['Ref'] ?? null,
            'idEstadoDoc' => $data['estado_doc'] ?? null,
            'Estado' => $data['estado'] ?? null,
            'Usuario' => $data['usuario']['id'] ?? null
        ];
        
        // Loguear el array completo
        Log::info('Datos registrados:', $array);

        $idLibro = $this->libroid($data['libro'],$data['empresa']);
        $dniruc = $data['correntistaData']['dni'] ?? $data['correntistaData']['ruc'];
        $idCorrentista = $this->correntistaid($dniruc,$data['empresa']);
        $idCuenta = $this->cuentaid($cuenta['cuenta'],$data['empresa']);
        if(!empty($data['CC'])){
            $idcc = $this->centroDeCostosid($data['CC'],$data['empresa']);
        }else{
            $idcc = null;
        }
        

        Tabla::create(['id_empresa' => $data['empresa'],
            'Mes' => $data['fecha_vaucher'] ? date('m', strtotime($data['fecha_vaucher'])) : null,
            'Libro' => $idLibro['id'] ?? null,
            'Vou' => $mov ?? null,
            'Fecha_Vou' => $data['fecha_vaucher'] ?? null,
            'GlosaGeneral' => isset($data['glosa']) ? strtoupper($data['glosa']) : null,
            'Corrent' => $idCorrentista['id'] ?? null,
            'TDoc' => $data['tdoc'] ?? null,
            'Ser' => $data['ser'] ?? null,
            'Num' => $data['num'] ?? null,
            'Cnta' => $idCuenta['id'] ?? null,
            'DebeHaber' => $cuenta['DebeHaber'] ?? null,
            'MontSoles' => $cuenta['monto'] ?? $cuenta['precioTotal'] ?? null,
            'MontDolares' =>  null,
            'TipCam' => $data['TipCam'] ?? null,
            'GlosaEpecifica' => isset($data['GlosaEpecifica']) ? strtoupper($data['GlosaEpecifica']) : (isset($data['glosa']) ? strtoupper($data['glosa']) : null),
            'CC' => $idcc['id'] ?? null,
            'TipMedioDePago' => $data['TipMedioDePago'] ?? null,
            'Fecha_Doc' => $data['fecha_doc'] ?? null,
            'Fecha_Ven' => $data['fecha_ven'] ?? null,
            'ADuaDsi' => $data['ADuaDsi'] ?? null,
            'TOpIgv' => $data['opigv'] ?? null,
            'BasImp' => $data['bas_imp'] ?? null,
            'IGV' => $data['igv'] ?? null,
            'NoGravadas' => $data['NoGravadas'] ?? null,
            'ISC' => $data['ISC'] ?? null,
            'ImpBolPla' => $data['ImpBolPla'] ?? null,
            'OtroTributo' => $data['OtroTributo'] ?? null,
            'CodMoneda' => $data['cod_moneda'] ?? null,
            'FechaEMod' => $data['fecha_emod'] ?? null,
            'TDocEMod' => $data['tdoc_emod'] ?? null,
            'SerEMod' => $data['ser_emod'] ?? null,
            'CodDepenDUAoDSI' => $data['CodDepenDUAoDSI'] ?? null,
            'NumEMod' => $data['num_emod'] ?? null,
            'FecEmiDetr' => $data['fec_emi_detr'] ?? null,
            'NumConstDer' => $data['num_const_der'] ?? null,
            'MarRet' => $data['MarRet'] ?? null,
            'ClasBienes' => $data['ClasBienes'] ?? null,
            'IdenContrat' => $data['IdenContrat'] ?? null,
            'Err1' => $data['Err1'] ?? null,
            'Err2' => $data['Err2'] ?? null,
            'Err3' => $data['Err3'] ?? null,
            'Err4' => $data['Err4'] ?? null,
            'RefInt' => $cuenta['Ref'] ?? null,
            'idEstadoDoc' => $data['estado_doc'] ?? null,
            'Estado' => $data['estado'] ?? null,
            'Usuario' => $data['usuario']['id'] ?? null]);
        
        Log::info('Inserted into Tabla successfully');
    }

    public function libroid($libro,$empresaid){
        $idlibro = Libro::select('id')->where('N',$libro)->where('id_empresa',$empresaid)->first();
        return $idlibro;
    }

    public function correntistaid($correstinta,$empresaid){
        $idCorrentista = Correntista::select('id')->where('ruc_emisor',$correstinta)->where('id_empresas',$empresaid)->first();
        return $idCorrentista;
    }

    public function cuentaid($cuenta,$empresaid){
        $idcuenta = PlanContable::select('id')->where('CtaCtable',$cuenta)->where('id_empresas',$empresaid)->first();
        return $idcuenta;
    }

    public function centroDeCostosid($cuenta,$empresaid){
        $idcc = CentroDeCostos::select('id')->where('Id_cc',$cuenta)->where('id_empresa',$empresaid)->first();
        return $idcc;
    }

    public function render()
    {
        return view('livewire.compra-venta-table', [
            'data' => $this->data,
            'libros' => $this->libros,
            'opigvs' => $this->opigvs,
            'estado_docs' => $this->estado_docs,
            'estados' => $this->estados,
            'ComprobantesPago' => $this->ComprobantesPago
        ]);
    }
}
