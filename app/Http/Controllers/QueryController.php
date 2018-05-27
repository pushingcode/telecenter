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
    	$rango = 9; //cantidad de meses como rango de consulta

    	//validando inputs

    	$reglas		 	= [
    						'n_contrato' => 'required|digits:7'
    					  ];

    	$mensajes	 	= [
    						'n_contrato.required'	=> 'El Numero de contrato es obligatorio.',
    					   	'n_contrato.digits'		=> 'El numero de contrato no es valido'
    					  ];

    	$validator 		= \Validator::make($request->all(),$reglas,$mensajes);
        
        if ($validator->fails()) {
            return \Redirect::back()
                        ->withErrors($validator)
                        ->withInput($request->all());
        }

    	//validando permisos por rol

        $control = time();
        $time = Carbon\Carbon::createFromTimestamp($control)->toDateTimeString();
        $start = microtime(true);

        $carbon_now = \Carbon\Carbon::now();
        $carbon_six = $carbon_now->subMonths($rango); //se establece 6 meses por cobertura de garantia

        $inicio = $carbon_six->toDateTimeString();
        $query = \DB::table('services')
        	->where("Numero_Cuenta", "=", $request->n_contrato)
        	->whereBetween("fecha",[$inicio, $time])
        	->orderBy('fecha', 'desc')
        	->get();


        $mensaje = "success*Consulta ejecutada";

        if(count($query) == 0){
        	$mensaje = "info*No existen resultados para la consulta";
        	return \Redirect::back()
        	->with(['header' => "Resultado de Consulta ". $request->n_contrato])
        	->withErrors($mensaje);
        }

        /*
        return \Redirect::back();
        */
        return view('result')
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
