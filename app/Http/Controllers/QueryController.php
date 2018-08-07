<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon;
use DB;
use Auth;

class QueryController extends Controller
{
    //

    /**
     * Busqueda de servicios por cuenta por rangos de fechas
     * Datos por Request:
     * Numero de Cuenta
     * Fecha Inicio
     * Fecha Fin
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function byTime(Request $request)
    {
    	$user = Auth::id();
    	$rango = 6; //cantidad de meses como rango de consulta

    	//validando inputs

    	$reglas		 	= [
    						'n_contrato' => 'required'
    					  ];

    	$mensajes	 	= [
    						'n_contrato.required'	=> 'info*El Numero de cliente es obligatorio.'
    					  ];

    	$validator 		= \Validator::make($request->all(),$reglas,$mensajes);

        if ($validator->fails()) {
            return \Redirect::back()
                        ->withErrors($validator)
                        ->withInput($request->all());
        }

    	//validando permisos por rol

        $preQuery = \DB::table('services')
                ->where("Numero_Cuenta", "=", $request->n_contrato)
                ->get();
        if(count($preQuery) == 0){
            $mensaje = "info*No existen resultados para la consulta";
            return view('error')
            ->with(['header' => "Sin Resultado en la Consulta ". $request->n_contrato])
            ->withErrors($mensaje);
        }

        $control = time();
        $time = Carbon\Carbon::createFromTimestamp($control)->toDateTimeString();
        $start = microtime(true);

        $carbon_now = \Carbon\Carbon::now();
        $carbon_six = $carbon_now->subMonths($rango); //se establece 6 meses por cobertura de garantia

        $inicio = $carbon_six->toDateTimeString();
        $query = \DB::table('services')
          ->where([
            ['Numero_Cuenta', $request->n_contrato],
            ['Estado','Completado']
          ])
        	->whereBetween("fecha",[$inicio, $time])
        	->orderBy('fecha', 'desc')
        	->get();

           // dd($request->n_contrato, $inicio, $time);
        $mensaje = "success*Consulta ejecutada en un rango de " . $rango . " meses";

        if(count($query) == 0){
        	$mensaje = "info*No existen resultados para la consulta en un rango de " . $rango . " meses";
        	return \Redirect::back()
        	->with(['header' => "Resultado de Consulta ". $request->n_contrato ." en un rango de " . $rango . " meses"])
        	->withErrors($mensaje);
        }

        /*
        return \Redirect::back();
        */

        /**
         * determinando la salida de la consulta
         * 'result'
         */
        if($request->from == 'admin'){
            $vista = 'result';
        }else{
            $vista = 'result2';
        }

        return view($vista)
        ->with([
        	'query'		=> $query,
        	'header'	=> "Consulta de contrato ". $request->n_contrato,
        	'rango'		=> $rango
        	])
        ->withErrors([
        	'mensaje'	=> $mensaje
        	]);


    }
}
