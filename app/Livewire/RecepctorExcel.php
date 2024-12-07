<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlantillaExport;
use App\Imports\ImportExcel;
use Livewire\WithFileUploads; // Importante: Añadir el trait para la carga de archivos
use App\Services\ApiService;
use App\Models\TipoDocumentoIdentidad;
use App\Models\Libro;
use App\Models\TipoComprobantePagoDocumento;
use App\Models\TipoDeMoneda;
use App\Models\OpIgv;
use App\Models\PlanContable;
use App\Models\CentroDeCostos;
use App\Models\Estado;
use App\Models\EstadoDocumento;
use App\Models\Tabla;
use App\Models\Correntista;
use Illuminate\Support\Facades\Session;
use App\Services\CompraVentaService;
use Illuminate\Support\Facades\DB;
use \PhpOffice\PhpSpreadsheet\Shared\Date;
use DateTime;
use Exception;


class RecepctorExcel extends Component
{
    use WithFileUploads; // Aquí se añade el trait necesario

    public $excelFile;
    protected $ApiService;
    protected $CompraVentaService;
    public $usuario;   
    public $empresaId;
    public $progreso = 0;
    public $iniciarProcesamiento = false; // Estado de control

    
    public function boot(ApiService $apiService,CompraVentaService $CompraVentaService)
    {
        // Asigna el servicio a una propiedad protegida de la clase
        $this->ApiService = $apiService;
        $this->usuario = Auth::user();
        $this->CompraVentaService = $CompraVentaService;
        // Log para verificar que el servicio se ha inyectado correctamente
        Log::info('ApiService cargado en boot:', ['service' => get_class($apiService)]);

        // Log para verificar que CompraVentaService se ha inyectado correctamente
        Log::info('CompraVentaService cargado en el método boot:', [
            'service' => get_class($this->CompraVentaService)
        ]);


        // Log para verificar si el usuario está autenticado y cargar sus datos
        if ($this->usuario) {
            Log::info('Usuario autenticado en boot:', ['usuario_id' => $this->usuario->id]);
            
        } else {
            Log::warning('Usuario no autenticado en el método boot.');
        }
        $this->empresaId = Session::get('EmpresaId');
        Log::info('empresaId cargado desde la sesión.', [
            'empresaId' => $this->empresaId
        ]);
    }
        

    public function Plantilla(){
        // Log para depuración
        Log::info('Generando la plantilla Excel');

        // Exportar el archivo Excel con datos personalizados
        return Excel::download(new PlantillaExport, 'plantilla.xlsx');
    }


    
    public function Procesar(){

        try {
            set_time_limit(1000); // Aumenta el tiempo de ejecución a 1000 segundos
            // Validar el archivo
            Log::info('Iniciando validación del archivo Excel.');
            $this->validate([
                'excelFile' => 'required|file|mimes:xls,xlsx|max:10240', // 10MB máximo
            ]);
    
            // Guardar temporalmente el archivo subido
            Log::info('El archivo ha sido validado correctamente. Guardando el archivo temporalmente.');
            $path = $this->excelFile->store('excel_files');
            Log::info('El archivo se guardó en la ruta temporal: ' . $path);
    
            // Procesar el archivo Excel
            Log::info('Iniciando procesamiento del archivo Excel.');
            $dataArray = Excel::toArray(new ImportExcel, $path);
            Log::info('El archivo Excel se ha procesado, obteniendo datos.');
            $data = $this->DataExcel($dataArray[0]);
            Log::info('Datos procesados con éxito: ', $data);
    
            // Borrar el archivo después de procesarlo si es necesario
            Log::info('Eliminando el archivo temporal después del procesamiento.');
            $path = null; // Si realmente necesitas eliminar el archivo puedes usar: Storage::delete($path);
    
            if ($data['success'] == 1) {
                session()->flash('message', 'El archivo se procesó correctamente.');
                Log::info('El archivo Excel se procesó correctamente.');
            } else {
                session()->flash('error', $data['error']);
                Log::error('Error en el procesamiento del archivo Excel: ' . $data['error']);
            }
    
            // Mensaje de confirmación
        } catch (\Exception $e) {
            // Captura cualquier excepción inesperada y la registra en el log
            Log::error('Ha ocurrido un error inesperado durante el procesamiento del archivo Excel: ' . $e->getMessage());
            session()->flash('error', 'Ha ocurrido un error inesperado. Inténtelo de nuevo.');
        }
    }

    public function DataExcel($array){
        $headers = ["Libro", "Fecha_Registo", "Fecha_Doc", "Fecha_Ven", "tdoc", "Corrent", "Raz Social", "TDoc", "Ser", "Num", "CodMoneda", "TipCam", "TOpIgv", "BasImp", "IGV", "NoGravadas", "ISC", "ImpBolPla", "OtroTributo", "Precio", "Glosa", "Cnta1", "Cnta2", "Cnta3", "CntaPrecio", "Mon1", "Mon2", "Mon3", "CC1", "CC2", "CC3", "CtaOtroT", "FechaEMod", "TDocEMod", "SerEMod", "NumEMod", "FecEmiDetr", "NumConstDer", "TieneDetracc", "CtaDetracc", "MontDetracc", "RefInt1", "RefInt2", "RefInt3", "EstadoDoc", "Estado"];

        // Verificamos si la colección tiene datos
        if (count($array) != 0) {
            // Convertimos la colección en un array PHP
            $arr = $array;

            // Log para depurar las cabeceras obtenidas del archivo
            Log::info('Cabeceras del archivo:', $arr[0]);

            // Comparamos las cabeceras
            if ($arr[0] === $headers) {
                Log::info('Validamos las cabeceras correctamente.');

                // Obtenemos el número de filas de datos
                $totalFilas = count($arr);

                if ($totalFilas > 1) {
                    Log::info('Se encontraron ' . ($totalFilas - 1) . ' filas de datos.');
                    
                    $associativeArray = [];

                    // Iteramos sobre las filas de datos, empezando desde la segunda fila
                    for ($k = 1; $k < $totalFilas; $k++) {
                        // Creamos el array asociativo para cada fila
                        $filaAsociativa = array_combine($headers, $arr[$k]);

                        if ($filaAsociativa === false) {
                            Log::error('Error al combinar cabeceras con datos en la fila: ' . $k);
                        } else {
                            $associativeArray[] = $filaAsociativa;
                        }
                    }

                    // Mostramos el array asociativo con los datos procesados
                    Log::info('Datos procesados:', $associativeArray);
                    $this -> progreso = 2;
                    
                    $data = $this -> PrepararDatos($associativeArray);
                    return $data;
                } else {
                    Log::info('No hay filas de datos para procesar.');
                    $data['success'] = '2';
                    $data['error'] = 'No hay filas de datos para procesar.';
                    return $data;
                }
            } else {
                Log::error('Las cabeceras no coinciden con las esperadas.');
                $data['success'] = '2';
                $data['error'] = 'Las cabeceras no coinciden con las esperadas.';
                return $data;
            }
        } else {
            Log::info('La colección está vacía. No hay datos para procesar.');
            $data['success'] = '2';
            $data['error'] = 'La colección está vacía. No hay datos para procesar';
            return $data;
        }
    }

    public function PrepararDatos($array){
        $dataArray = [];
        $cont = 0;
        $prog = 48 / count($array);
        foreach($array as $row) {
            // Log para ver el contenido de cada fila antes de la validación
            if ($row['Libro'] <> null){
                $cont++;
                $row['fila'] = $cont;
                Log::info('Fila antes de validación:', ['row' => $row]);
                // Procesa la fila con validación
                $resultado = $this->validacionDeDatos($row);
                if($resultado['success']  == 2){
                    return $resultado;
                }

                // Agregar el resultado validado al array final
                $dataArray[] = $resultado;
                $this -> progreso = $this -> progreso + $prog;
            } else {
                if ($cont == 0){
                    $resultado['success'] = 2;
                    $resultado['error'] = 'No se proceso ninguna fila';
                    return;
                }
                
            }
        }

        // Log para ver el array final después del procesamiento completo
        Log::info('Array final después de la preparación de datos:', ['dataArray' => $dataArray]);

        $dataN = $this -> insertData($dataArray);        
        Log::info('Datos a procesar: ',$dataN);
        return $dataN; // Devuelve el array final si es necesario
    }

    public function validacionDeDatos($row){
                
        $campos = [
            'tdoc' => $row['tdoc'] ?? 'No definido',
            'Libro' => $row['Libro'] ?? 'No definido',
            'Fecha_Registo' => $row['Fecha_Registo'] ?? 'No definido',
            'Fecha_Doc' => $row['Fecha_Doc'] ?? 'No definido',
            'Corrent' => $row['Corrent'] ?? 'No definido',
            'Raz Social' => $row['Raz Social'] ?? 'No definido',
            'TDoc' => $row['TDoc'] ?? 'No definido',
            'Ser' => $row['Ser'] ?? 'No definido',
            'Num' => $row['Num'] ?? 'No definido',
            'CodMoneda' => $row['CodMoneda'] ?? 'No definido',
            'TOpIgv' => $row['TOpIgv'] ?? 'No definido',
            'Precio' => $row['Precio'] ?? 'No definido',
            'Glosa' => $row['Glosa'] ?? 'No definido',
            'Cnta1' => $row['Cnta1'] ?? 'No definido',
            'CntaPrecio' => $row['CntaPrecio'] ?? 'No definido',
            'Mon1' => $row['Mon1'] ?? 'No definido',
            'EstadoDoc' => $row['EstadoDoc'] ?? 'No definido',
            'Estado' => $row['Estado'] ?? 'No definido',
        ];
    
        // Array para almacenar los campos que no pasan la validación
        $camposNoValidados = [];
    
        // Revisar cada campo para verificar si está vacío o no definido
        foreach ($campos as $campo => $valor) {
            if (empty($valor) || $valor === 'No definido') {
                // Almacenar el campo que no pasa la validación
                $camposNoValidados[] = $campo;
            }
        }
    
        // Registrar los campos que no pasaron la validación si hay alguno
        if (!empty($camposNoValidados)) {
            Log::warning("La fila no pasó la validación. Campos faltantes o vacíos: ", ['camposNoValidados' => $camposNoValidados]);
            $data['success'] = 2;
            $data['error'] = "La fila numero " .$row['fila']. " no pasó la validación. Campos faltantes o vacíos: " . implode(', ', $camposNoValidados);
            return $data;
        }
    
        // Si todos los campos pasaron la validación
        Log::info("La fila pasó la validación correctamente.");

        // Validación de TipoDocumentoIdentidad
        if (TipoDocumentoIdentidad::where('N', $row['tdoc'])->exists()) {
            $validatedData['tdoc'] = $row['tdoc'];
            Log::info("Tipo de documento de identidad válido para la fila " . $row['fila'], [
                'tdoc' => $row['tdoc']
            ]);
        } else {
            Log::warning("Tipo de documento de identidad no válido para la fila " . $row['fila'], [
                'tdoc' => $row['tdoc']
            ]);
            $Ndata['success'] = 2;
            $Ndata['error'] = "La fila número " . $row['fila'] . " tiene un número de documento de identidad no válido.";
            return $Ndata;
        }

        // Validación del Libro
        if (Libro::whereIn('N', ['01', '02'])->where('id_empresa',$this->empresaId['id'])->exists()) {
            $validatedData['libro'] = $row['Libro'];
            Log::info("Número de libro válido para la fila " . $row['fila'], [
                'libro' => $row['Libro']
            ]);
        } else {
            Log::warning("Número de libro no válido para la fila " . $row['fila'], [
                'libro' => $row['Libro']
            ]);
            $Ndata['success'] = 2;
            $Ndata['error'] = "La fila número " . $row['fila'] . " tiene un número de libro no válido.";
            return $Ndata;
        }

        // Validación de Correntista a través de ApiService
        Log::info("Solicitando correntista a ApiService para la fila " . $row['fila'], [
            'tdoc' => $row['tdoc'],
            'Corrent' => $row['Corrent']
        ]);
        $data = $this->ApiService->REntidad($row['tdoc'], $row['Corrent']);
        if ($data['success'] == 1) {
            $correntistaData = $data['desc'];
            $validatedData['correntistaData'] = $correntistaData;
        } else {
            $Ndata['success'] = 2;
            $Ndata['error'] = "La fila número " . $row['fila'] . " " . $data['error'];
            return $Ndata;
        }
        
        foreach (['Fecha_Registo', 'Fecha_Doc', 'Fec_Ven', 'FechaEMod', 'FecEmiDetr'] as $fec) {
            $fecha = $row[$fec] ?? null; // Fecha en formato DD/MM/YYYY o nulo si no existe
        
            // Log para verificar la fecha inicial
            Log::info("Validando fecha para la fila " . $row['fila'], [
                'campo' => $fec,
                'valor_inicial' => $fecha
            ]);
        
            // Verificar si la fecha es nula (para el caso de Fec_Ven)
            if (is_null($fecha)) {
                $validatedData[$fec] = null;
                Log::info("Fecha nula asignada para el campo " . $fec . " en la fila " . $row['fila']);
                continue; // Saltar a la siguiente iteración sin validación
            }
        
            // Convertir el valor numérico de Excel a una fecha si es necesario
            if (is_numeric($fecha)) {
                $fechaValida = Date::excelToDateTimeObject($fecha);
                $fechaConvertida = $fechaValida->format('Y-m-d'); // Formato de salida deseado
                $validatedData[$fec] = $fechaConvertida;
        
                Log::info("Fecha numérica convertida correctamente en la fila " . $row['fila'], [
                    'campo' => $fec,
                    'valor_convertido' => $fechaConvertida
                ]);
            } else {
                // Validación para fechas en formato d/m/Y
                $formatoEntrada = "d/m/Y";
                $fechaValida = DateTime::createFromFormat($formatoEntrada, $fecha);
        
                if ($fechaValida && $fechaValida->format($formatoEntrada) === $fecha) {
                    $fechaConvertida = $fechaValida->format('Y-m-d');
                    $validatedData[$fec] = $fechaConvertida;
        
                    Log::info("Fecha válida y convertida en la fila " . $row['fila'], [
                        'campo' => $fec,
                        'valor_convertido' => $fechaConvertida
                    ]);
                } else {
                    Log::warning("Fecha no válida para el campo " . $fec . " en la fila " . $row['fila'], [
                        'valor_inicial' => $fecha
                    ]);
                    $Ndata['success'] = 2;
                    $Ndata['error'] = "La fila número " . $row['fila'] . " el campo " . $fec . " no es válido";
                    return $Ndata;
                }
            }
        }
        
        $fieldsToValidate = ['TDoc', 'TDocEMod'];

        foreach ($fieldsToValidate as $field) {
            // Log inicial para verificar el valor del campo
            Log::info("Validando campo comprobante en la fila " . $row['fila'], [
                'campo' => $field,
                'valor' => $row[$field] ?? 'No definido'
            ]);
        
            // Verificar si el valor existe y no es nulo
            if (isset($row[$field]) && !is_null($row[$field])) {
                // Verificar si el comprobante existe en la base de datos
                if (TipoComprobantePagoDocumento::where('N', $row[$field])->exists()) {
                    $validatedData[$field] = $row[$field];
                    Log::info("Comprobante válido para el campo " . $field . " en la fila " . $row['fila'], [
                        'valor' => $row[$field]
                    ]);
                } else {
                    Log::warning("Número de comprobante no válido en " . $field . " en la fila " . $row['fila'], [
                        'valor' => $row[$field]
                    ]);
                    $Ndata['success'] = 2;
                    $Ndata['error'] = "La fila número " . $row['fila'] . " tiene un número de comprobante no válido en " . $field . ".";
                    return $Ndata;
                }
            } else {
                $validatedData[$field] = null;
                Log::info("Valor nulo asignado para el campo " . $field . " en la fila " . $row['fila']);
            }
        }
        
        // Asignación de valores directos
        $fields = ['Ser', 'Num', 'SerEMod', 'NumEMod', 'RefInt1', 'RefInt2', 'RefInt3', 'NumConstDer', 'Glosa'];
        
        foreach ($fields as $field) {
            $validatedData[$field] = $row[$field] ?? null;
            Log::info("Campo asignado a validatedData", [
                'campo' => $field,
                'valor' => $validatedData[$field]
            ]);
        }
        
        // Validación del Tipo de Moneda
        Log::info("Validando código de moneda para la fila " . $row['fila'], [
            'CodMoneda' => $row['CodMoneda'] ?? 'No definido'
        ]);
        
        if (TipoDeMoneda::where('COD', $row['CodMoneda'])->exists()) {
            $validatedData['cod_moneda'] = $row['CodMoneda'];
            Log::info("Código de moneda válido en la fila " . $row['fila'], [
                'cod_moneda' => $row['CodMoneda']
            ]);
        } else {
            Log::warning("Código de moneda no válido en la fila " . $row['fila'], [
                'cod_moneda' => $row['CodMoneda']
            ]);
            $Ndata['success'] = 2;
            $Ndata['error'] = "La fila número " . $row['fila'] . " tiene un código de moneda no válido.";
            return $Ndata;
        }
        
        // Validación de la Operación IGV
        Log::info("Validando operación IGV para la fila " . $row['fila'], [
            'TOpIgv' => $row['TOpIgv'] ?? 'No definido'
        ]);
        
        if (OpIgv::where('Id', $row['TOpIgv'])->exists()) {
            $validatedData['opigv'] = $row['TOpIgv'];
            Log::info("Operación IGV válida en la fila " . $row['fila'], [
                'opigv' => $row['TOpIgv']
            ]);
        } else {
            Log::warning("Operación IGV no válida en la fila " . $row['fila'], [
                'opigv' => $row['TOpIgv']
            ]);
            $Ndata['success'] = 2;
            $Ndata['error'] = "La fila número " . $row['fila'] . " tiene una operación de IGV no válida.";
            return $Ndata;
        }
        

        // Definir los campos que se deben validar como números
        $fieldsToValidate = ['BasImp', 'IGV', 'NoGravadas', 'ISC', 'ImpBolPla', 'OtroTributo', 'Precio', 'Mon1', 'Mon2', 'Mon3', 'MontDetracc'];

        foreach ($fieldsToValidate as $field) {
            // Log para verificar el valor inicial del campo
            Log::info("Validando campo numérico en la fila " . $row['fila'], [
                'campo' => $field,
                'valor' => $row[$field] ?? 'No definido'
            ]);

            // Verificar si el valor existe y no es nulo
            if (isset($row[$field]) && !is_null($row[$field])) {
                // Verificar si el valor es numérico
                if (is_numeric($row[$field])) {
                    $validatedData[strtolower($field)] = floatval($row[$field]); // Convertir y almacenar como float
                    Log::info("Campo numérico válido en la fila " . $row['fila'], [
                        'campo' => $field,
                        'valor' => $validatedData[strtolower($field)]
                    ]);
                } else {
                    Log::warning("Campo no numérico en la fila " . $row['fila'], [
                        'campo' => $field,
                        'valor' => $row[$field]
                    ]);
                    $Ndata['success'] = 2;
                    $Ndata['error'] = "La fila número " . $row['fila'] . " el campo " . $field . " no tiene formato numérico.";
                    return $Ndata;
                }
            } else {
                $validatedData[strtolower($field)] = null;
                Log::info("Valor nulo asignado para el campo numérico " . $field . " en la fila " . $row['fila']);
            }
        }

        // Validación de cuentas en el Plan Contable
        $cuentas = ['Cnta1', 'Cnta2', 'Cnta3', 'CtaOtroT', 'CtaDetracc'];

        foreach ($cuentas as $cnta) {
            // Log inicial para verificar el valor del campo
            Log::info("Validando cuenta en el Plan Contable en la fila " . $row['fila'], [
                'campo' => $cnta,
                'valor' => $row[$cnta] ?? 'No definido'
            ]);

            // Verificar si el valor existe en $row y no es nulo
            if (isset($row[$cnta]) && !is_null($row[$cnta])) {
                // Verificar si la cuenta existe en PlanContable
                if (PlanContable::where('CtaCtable', $row[$cnta])->where('id_empresas',$this->empresaId['id'])->exists()) {
                    $validatedData[$cnta] = [
                        'cuenta' => $row[$cnta],
                        'DebeHaber' => null,
                    ];
                    Log::info("Cuenta válida en el Plan Contable para el campo " . $cnta . " en la fila " . $row['fila'], [
                        'cuenta' => $row[$cnta]
                    ]);
                } else {
                    Log::warning("Cuenta no válida en el Plan Contable para el campo " . $cnta . " en la fila " . $row['fila'], [
                        'cuenta' => $row[$cnta]
                    ]);
                    $Ndata['success'] = 2;
                    $Ndata['error'] = "La fila número " . $row['fila'] . " la cuenta $cnta no es válida en el Plan Contable.";
                    return $Ndata;
                }
            } else {
                $validatedData[$cnta] = [
                    'cuenta' => null,
                    'debehaber' => null,
                ];
                Log::info("Valor nulo asignado para la cuenta " . $cnta . " en la fila " . $row['fila']);
            }
        }

        if (PlanContable::where('CtaCtable', $row['CntaPrecio'])->where('id_empresas',$this->empresaId['id'])->exists()) {
            $validatedData['CntaPrecio'] = [
                'cuenta' => $row['CntaPrecio'],
                'DebeHaber' => null,
                'precioTotal' => $row['Precio'],
            ];
            Log::info("Cuenta válida en el Plan Contable para el campo " . $row['CntaPrecio'] . " en la fila " . $row['fila'], [
                'cuenta' => $row['CntaPrecio']
            ]);
        } else {
            Log::warning("Cuenta no válida en el Plan Contable para el campo " . $row['CntaPrecio'] . " en la fila " . $row['fila'], [
                'cuenta' => $row['CntaPrecio']
            ]);
            $Ndata['success'] = 2;
            $Ndata['error'] = "La fila número " . $row['fila'] . " la cuenta ".$row['CntaPrecio']." no es válida en el Plan Contable.";
            return $Ndata;
        }

        
        // Validación de centros de costos
        foreach (['CC1', 'CC2', 'CC3'] as $CC) {
            // Log inicial para verificar el valor del centro de costo
            Log::info("Validando centro de costo en la fila " . $row['fila'], [
                'campo' => $CC,
                'valor' => $row[$CC] ?? 'No definido'
            ]);

            if (isset($row[$CC]) && !is_null($row[$CC])) {
                // Verificar si el centro de costos existe en la base de datos
                if (CentroDeCostos::where('Id', $row[$CC])->where('id_empresa',$this->empresaId['id'])->exists()) {
                    $validatedData[$CC] = $row[$CC];
                    Log::info("Centro de costo válido en la fila " . $row['fila'], [
                        'campo' => $CC,
                        'valor' => $row[$CC]
                    ]);
                } else {
                    Log::warning("Centro de costo no válido en " . $CC . " en la fila " . $row['fila'], [
                        'valor' => $row[$CC]
                    ]);
                    $Ndata['success'] = 2;
                    $Ndata['error'] = "La fila número " . $row['fila'] . " el centro de costos " . $CC . " no es válido.";
                    return $Ndata;
                }
            } else {
                $validatedData[$CC] = null;
                Log::info("Centro de costo nulo asignado para el campo " . $CC . " en la fila " . $row['fila']);
            }
        }

        // Validación de TieneDetracc
        Log::info("Validando campo TieneDetracc en la fila " . $row['fila'], [
            'TieneDetracc' => $row['TieneDetracc'] ?? 'No definido'
        ]);

        if (isset($row['TieneDetracc']) && !is_null($row['TieneDetracc'])) {
            if ($row['TieneDetracc'] == 'Si' || $row['TieneDetracc'] == 'No') {
                $validatedData['TieneDetracc'] = $row['TieneDetracc'];
                Log::info("Campo TieneDetracc válido en la fila " . $row['fila'], [
                    'TieneDetracc' => $row['TieneDetracc']
                ]);
            } else {
                Log::warning("Valor no válido en TieneDetracc en la fila " . $row['fila'], [
                    'TieneDetracc' => $row['TieneDetracc']
                ]);
                $Ndata['success'] = 2;
                $Ndata['error'] = "La fila número " . $row['fila'] . " el valor tiene que ser Si o No.";
                return $Ndata;
            }
        } else {
            $validatedData['TieneDetracc'] = null;
            Log::info("Valor nulo asignado para TieneDetracc en la fila " . $row['fila']);
        }

        // Validación de EmpresaId
        $validatedData['EmpresaId'] = $this->empresaId->id ?? null;
        Log::info("EmpresaId asignado a validatedData", [
            'EmpresaId' => $validatedData['EmpresaId']
        ]);

        // Validación de EstadoDoc
        Log::info("Validando EstadoDoc para la fila " . $row['fila'], [
            'EstadoDoc' => $row['EstadoDoc'] ?? 'No definido'
        ]);

        if (EstadoDocumento::where('id', $row['EstadoDoc'])->exists()) {
            $validatedData['EstadoDoc'] = $row['EstadoDoc'];
            Log::info("EstadoDoc válido en la fila " . $row['fila'], [
                'EstadoDoc' => $row['EstadoDoc']
            ]);
        } else {
            Log::warning("EstadoDoc no válido en la fila " . $row['fila'], [
                'EstadoDoc' => $row['EstadoDoc']
            ]);
            $Ndata['success'] = 2;
            $Ndata['error'] = "La fila número " . $row['fila'] . " tiene que tener un estado válido.";
            return $Ndata;
        }

        // Validación de Estado
        Log::info("Validando Estado para la fila " . $row['fila'], [
            'Estado' => $row['Estado'] ?? 'No definido'
        ]);

        if (Estado::where('N', $row['Estado'])->exists()) {
            $validatedData['Estado'] = $row['Estado'];
            Log::info("Estado válido en la fila " . $row['fila'], [
                'Estado' => $row['Estado']
            ]);
        } else {
            Log::warning("Estado no válido en la fila " . $row['fila'], [
                'Estado' => $row['Estado']
            ]);
            $Ndata['success'] = 2;
            $Ndata['error'] = "La fila número " . $row['fila'] . " tiene que tener un estado válido.";
            return $Ndata;
        }


        // Log the validated data
        Log::info('Datos validados: ', $validatedData);

        // Definir el mapeo de los campos
        $fieldsMap = [
            'correntistaData' => 'correntistaData',
            'libro' => 'libro',
            'fecha_doc' => 'Fecha_Doc',
            'fecha_ven' => 'Fec_Ven',
            'fecha_vaucher' => 'Fecha_Registo',
            'num' => 'Num',
            'tdoc' => 'TDoc',
            'cod_moneda' => 'cod_moneda',
            'opigv' => 'opigv',
            'bas_imp' => 'basimp',
            'igv' => 'igv',
            'cnta_precio' => 'CntaPrecio',
            'glosa' => 'Glosa',
            'cnta1' => 'Cnta1',
            'mon1' => 'mon1',
            'estado_doc' => 'EstadoDoc',
            'estado' => 'Estado',
            'ser' => 'Ser',
            'no_gravadas' => 'nogravadas',
            'isc' => 'isc',
            'imp_bol_pla' => 'impbolpla',
            'otro_tributo' => 'otrotributo',
            'precio' => 'precio',
            'mon2' => 'mon2',
            'mon3' => 'mon3',
            'cc1' => 'CC1',
            'cc2' => 'CC2',
            'cc3' => 'CC3',
            'cta_otro_t' => 'CtaOtroT',
            'fecha_emod' => 'FechaEMod',
            'tdoc_emod' => 'TDocEMod',
            'ser_emod' => 'SerEMod',
            'num_emod' => 'NumEMod',
            'fec_emi_detr' => 'FecEmiDetr',
            'num_const_der' => 'NumConstDer',
            'tiene_detracc' => 'TieneDetracc',
            'cta_detracc' => 'CtaDetracc',
            'mont_detracc' => 'montdetracc',
            'ref_int1' => 'RefInt1',
            'ref_int2' => 'RefInt2',
            'ref_int3' => 'RefInt3',
        ];
        
        // Asignar valores de validatedData a NValidateData
        foreach ($fieldsMap as $targetField => $sourceField) {
            // Verificar si el campo es un array anidado
            if (strpos($sourceField, '.') !== false) {
                [$mainField, $subField] = explode('.', $sourceField);
                $NValidateData[$targetField] = $validatedData[$mainField][$subField] ?? null;
                Log::info("Asignación de campo anidado", [
                    'targetField' => $targetField,
                    'mainField' => $mainField,
                    'subField' => $subField,
                    'valor' => $NValidateData[$targetField]
                ]);
            } else {
                $NValidateData[$targetField] = $validatedData[$sourceField] ?? null;
                Log::info("Asignación de campo simple", [
                    'targetField' => $targetField,
                    'sourceField' => $sourceField,
                    'valor' => $NValidateData[$targetField]
                ]);
            }
        }
        
        // Log final para verificar el resultado completo de NValidateData
        Log::info("Resultado final de NValidateData después de la asignación", [
            'NValidateData' => $NValidateData
        ]);
        
        $data = $this->CompraVentaService->prepararDatos(
            $NValidateData,
            $this->usuario,
            $validatedData['EmpresaId'],
            $validatedData['correntistaData'],
            $validatedData['libro'],
            $validatedData['TDoc'],
            $validatedData['igv'],
            $validatedData['otrotributo'],
            $validatedData['TieneDetracc'],
            $validatedData['precio'],
            $validatedData['montdetracc'],
            $validatedData['mon1'],
            $validatedData['mon2'],
            $validatedData['mon3'],
            $validatedData['CC1'],
            $validatedData['CC2'],
            $validatedData['CC3'],
            null,
            $validatedData['cod_moneda'],
            $validatedData['Cnta1'],
            $validatedData['Cnta2'],
            $validatedData['Cnta3'],
            $validatedData['RefInt1'],  // <---- Pasar ref_int1
            $validatedData['RefInt2'],  // <---- Pasar ref_int2
            $validatedData['RefInt3']   // <---- Pasar ref_int3
        );
        
        Log::info("Dato procesado y listo para su expotacion a la DB:", $data);

        $resultado['success'] = 1;
        $resultado['fila'] = $row['fila'];
        $resultado['data'] = $data;

        return $resultado;
        
        
    }


    public function insertData($data)
    {
        Log::info('Starting batch data insertion');
        DB::beginTransaction(); // Iniciar la transacción
    
        try {
            foreach ($data as $rec) {
                // Verificar que el item existe antes de proceder

                $index = $rec['data'];

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
    
            DB::commit(); // Confirmar la transacción
            Log::info('Data insertion completed successfully');
            
        } catch (Exception $e) {
            DB::rollBack(); // Revertir la transacción si hay un error
            Log::error('Data insertion failed', ['error' => $e->getMessage()]);
            $data['success'] = 2;
            $data['error'] = $e;
            return $data;
        }

        $dato['success'] = 1;
        return $dato;

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
            'NoGravadas' => $data['no_gravadas'] ?? null,
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
        $dniruc = $data['correntistaData']['ruc_emisor'];
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
        return view('livewire.recepctor-excel');
    }
}
