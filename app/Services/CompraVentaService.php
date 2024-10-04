<?php

namespace App\Services;

use App\Models\PlanContable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CompraVentaService
{
    public function calcularMontos(&$data, $tip_cam, $cod_moneda, $mon1, $mon2, $mon3, $igv, $otro_tributo, $bas_imp)
    {
        $montoDolares = [
            'mon1' => $mon1,
            'mon2' => $mon2,
            'mon3' => $mon3,
            'igv' => $igv,
            'otro_tributo' => $otro_tributo,
            'bas_imp' => $bas_imp,
        ];

        Log::info('Montos en dólares antes de la conversión:', $montoDolares);

        if ($cod_moneda == 'USD') {
            $data['mon1'] = round($mon1 * $tip_cam, 2);
            $data['mon2'] = round($mon2 * $tip_cam, 2);
            $data['mon3'] = round($mon3 * $tip_cam, 2);
            $data['igv'] = round($igv * $tip_cam, 2);
            $data['otro_tributo'] = round($otro_tributo * $tip_cam, 2);
            $data['bas_imp'] = round($bas_imp * $tip_cam, 2);

            Log::info('Montos después de la conversión:', [
                'mon1' => $data['mon1'],
                'mon2' => $data['mon2'],
                'mon3' => $data['mon3'],
                'igv' => $data['igv'],
                'otro_tributo' => $data['otro_tributo'],
                'bas_imp' => $data['bas_imp']
            ]);
        }
    }

    public function agregarDestinos($cuenta, $monto, $cc, $ref, $libro)
    {
        Log::info('Valor de libro ingresando a agregarDestinos: ' . $libro);

        $destinos = PlanContable::select('Dest1D', 'Dest1H', 'Dest2D', 'Dest2H')
            ->where('CtaCtable', $cuenta)
            ->first();

        Log::info('Consulta de destinos para la cuenta: ' . $cuenta, ['destinos' => $destinos]);

        $resultados = [];
        if ($destinos) {
            $destinosArray = $destinos->toArray();
            foreach ($destinosArray as $key => $dest) {
                if (trim($dest) !== '') {
                    if ($libro == '01') {
                        $DebeHaber = ($key == 'Dest1D' || $key == 'Dest2D') ? 1 : 2;
                    } else {
                        $DebeHaber = ($key == 'Dest1D' || $key == 'Dest2D') ? 2 : 1;
                    }

                    Log::info('Asignación de DebeHaber', [
                        'libro' => $libro,
                        'key' => $key,
                        'DebeHaber' => $DebeHaber,
                        'cuenta' => $dest
                    ]);

                    $resultados[] = [
                        'cuenta' => $dest,
                        'DebeHaber' => $DebeHaber,
                        'monto' => $monto,
                        'cc' => $cc,
                        'ref' => $ref
                    ];

                    Log::info('Destino añadido', [
                        'cuenta' => $dest,
                        'DebeHaber' => $DebeHaber,
                        'monto' => $monto,
                        'cc' => $cc,
                        'ref' => $ref
                    ]);
                } else {
                    Log::info('Destino vacío', ['key' => $key]);
                }
            }
        } else {
            Log::info('No se encontraron destinos para la cuenta', ['cuenta' => $cuenta]);
        }

        Log::info('Libro utilizado para asignación de DebeHaber: ' . $libro);

        return $resultados;
    }

    public function validacionesLibros(&$data, $libro, $tdoc, $igv, $otro_tributo, $tiene_detracc, $precio, $mont_detracc)
{
    Log::info('Iniciando validacionesLibros con los siguientes valores:', [
        'libro' => $libro,
        'tdoc' => $tdoc,
        'igv' => $igv,
        'otro_tributo' => $otro_tributo,
        'tiene_detracc' => $tiene_detracc,
        'precio' => $precio,
        'mont_detracc' => $mont_detracc,
    ]);


    if ($libro == '01') {
        if ($tdoc != '07') {
            Log::info('Libro es 01 y tdoc no es 07.');

            $data['cuenta_igv'] = [
                'DebeHaber' => 1,
                'valor' => 1673,
                'igv' => $igv,
            ];

            Log::info('Asignado cuenta IGV:', $data['cuenta_igv']);

            if (!empty($otro_tributo)) {
                $data['cta_otro_t']['DebeHaber'] = 1;
                Log::info('Otro tributo no está vacío, asignado cta_otro_t DebeHaber a 1.');
            }

            if (empty($tiene_detracc) || $tiene_detracc === 'no') {
                $data['cnta_precio']['DebeHaber'] = 2;
                $data['cnta_precio']['precioTotal'] = $precio;

                Log::info('No tiene detracción o tiene_detracc es "no". Asignado cnta_precio:', [
                    'DebeHaber' => $data['cnta_precio']['DebeHaber'],
                    'precioTotal' => $data['cnta_precio']['precioTotal']
                ]);
            } else {
                if (!empty($mont_detracc)) {
                    $data['cta_detracc']['DebeHaber'] = 2;
                    Log::info('MontDetracc no está vacío. Asignado cta_detracc DebeHaber a 2.');
                }
            }
        } else {
            Log::info('Libro es 01 pero tdoc es 07.');

            $data['cuenta_igv'] = [
                'DebeHaber' => 2,
                'valor' => 1673,
                'igv' => $igv,
            ];

            Log::info('Asignado cuenta IGV en else (tdoc es 07):', $data['cuenta_igv']);

            if (!empty($otro_tributo)) {
                $data['cta_otro_t']['DebeHaber'] = 2;
                Log::info('Otro tributo no está vacío, asignado cta_otro_t DebeHaber a 2.');
            }

            if (empty($tiene_detracc) || $tiene_detracc === 'no') {
                $data['cnta_precio']['DebeHaber'] = 1;
                $data['cnta_precio']['precioTotal'] = $precio;

                Log::info('No tiene detracción o tiene_detracc es "no" en else (tdoc es 07). Asignado cnta_precio:', [
                    'DebeHaber' => $data['cnta_precio']['DebeHaber'],
                    'precioTotal' => $data['cnta_precio']['precioTotal']
                ]);
            } else {
                if (!empty($mont_detracc)) {
                    $data['cta_detracc']['DebeHaber'] = 1;
                    Log::info('MontDetracc no está vacío en else (tdoc es 07). Asignado cta_detracc DebeHaber a 1.');
                }
            }
        }
    } else {
        Log::info('Libro no es 01.');

        $data['cuenta_igv'] = [
            'DebeHaber' => 2,
            'valor' => 40111,
            'igv' => $igv,
        ];

        Log::info('Asignado cuenta IGV en else:', $data['cuenta_igv']);

        if (!empty($otro_tributo)) {
            $data['cta_otro_t']['DebeHaber'] = 2;
            Log::info('Otro tributo no está vacío, asignado cta_otro_t DebeHaber a 2.');
        }

        if (empty($tiene_detracc) || $tiene_detracc === 'no') {
            $data['cnta_precio']['DebeHaber'] = 1;
            $data['cnta_precio']['precioTotal'] = $precio;

            Log::info('No tiene detracción o tiene_detracc es "no" en else. Asignado cnta_precio:', [
                'DebeHaber' => $data['cnta_precio']['DebeHaber'],
                'precioTotal' => $data['cnta_precio']['precioTotal']
            ]);
        } else {
            if (!empty($mont_detracc)) {
                $data['cta_detracc']['DebeHaber'] = 1;
                Log::info('MontDetracc no está vacío en else. Asignado cta_detracc DebeHaber a 1.');
            }
        }
    }

    Log::info('Finalizando validacionesLibros con los datos:', $data);
}

public function asignarDebeHaber(&$data, $libro)
{
    Log::info('Iniciando asignación de DebeHaber según el libro: ' . $libro);

    // Procesar cnta1, cnta2, cnta3
    foreach (['cnta1', 'cnta2', 'cnta3'] as $cuentaKey) {
        if (!empty($data[$cuentaKey]['cuenta'])) {
            $DebeHaber = ($libro == '01') ? 1 : 2;
            $data[$cuentaKey]['DebeHaber'] = $DebeHaber;

            Log::info('Asignación de DebeHaber para ' . $cuentaKey, [
                'cuenta' => $data[$cuentaKey]['cuenta'],
                'DebeHaber' => $data[$cuentaKey]['DebeHaber'],
            ]);
        } else {
            Log::info($cuentaKey . ' está vacío o no contiene cuenta.');
        }
    }

    Log::info('Finalizando asignación de DebeHaber:', $data);
}

    public function prepararDatos($validatedData, $usuario, $empresaId, $correntistaData, $libro, $tdoc, $igv, $otro_tributo, $tiene_detracc, $precio, $mont_detracc, $mon1, $mon2, $mon3, $cc1, $cc2, $cc3, $tip_cam, $cod_moneda, $cnta1, $cnta2, $cnta3, $ref_int1, $ref_int2, $ref_int3)
    {
        Log::info('Preparando los datos para procesamiento...');
        
        $data = [];
        foreach ($validatedData as $key => $value) {
            if (!is_null($value) || $value === 0) {
                $data[$key] = $value;
            }
        }
        Log::info('Datos iniciales preparados: ', $data);
    
        if (Auth::check()) {
            $data['usuario'] = [
                'id' => Auth::user()->id,
                'email' => Auth::user()->email,
            ];
            Log::info('Información del usuario autenticado añadida: ', $data['usuario']);
        }
    
        if (!empty($empresaId)) {
            $data['empresa'] = $empresaId;
            Log::info('ID de la empresa añadida: ' . $empresaId);
        }
    
        if (!empty($correntistaData)) {
            $data['correntistaData'] = $correntistaData;
            Log::info('Datos del correntista añadidos: ', $correntistaData);
        }
    
        Log::info('Antes de realizar validaciones adicionales en el libro.');
        $this->validacionesLibros($data, $libro, $tdoc, $igv, $otro_tributo, $tiene_detracc, $precio, $mont_detracc);
        Log::info('Después de realizar validaciones adicionales en el libro: ', $data);
    
        $this->calcularMontos($data, $tip_cam, $cod_moneda, $mon1, $mon2, $mon3, $igv, $otro_tributo, $bas_imp = $data['bas_imp'] ?? 0);
        Log::info('Montos calculados: ', $data);
    
        // Asegurarse de pasar correctamente $cnta1, $cnta2, $cnta3
        foreach (['cnta1', 'cnta2', 'cnta3'] as $cuentaKey) {
            $cuenta = ${$cuentaKey};
            if (!empty($cuenta['cuenta'])) {
                $monto = ${"mon" . substr($cuentaKey, -1)};
                $cc = ${"cc" . substr($cuentaKey, -1)};
                $ref = ${"ref_int" . substr($cuentaKey, -1)};
                Log::info('Antes de agregar destinos para ' . $cuentaKey . ': Libro - ' . $data['libro']);
                $cuentaDestinos = $this->agregarDestinos($cuenta['cuenta'], $monto, $cc, $ref, $data['libro']);
                if (!empty($cuentaDestinos)) {
                    $data["{$cuentaKey}_destinos"] = $cuentaDestinos;
                    Log::info('Destinos añadidos para ' . $cuentaKey . ': ', $cuentaDestinos);
                }
                $data[$cuentaKey] = $cuenta;
            }
        }
    
        if (array_key_exists('tiene_detracc', $data) && $data['tiene_detracc'] === 'si' && !empty($data['mont_detracc'])) {
            $data['precio'] -= $data['mont_detracc'];
            Log::info('Precio ajustado por detracción: ' . $data['precio']);
        }
    
        Log::info('Datos finales con cálculos y destinos: ', $data);
    
        return $data;
    }
    
}
