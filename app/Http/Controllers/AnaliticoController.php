<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon;
use DB;
use Auth;
use Log;

class AnaliticoController extends Controller
{
    //
    /**
     * Analisis de Visitas pendientes
     * Los datos entrantes provienen de ordenes de estado pendientes
     * Verificar que la tabla esta vacia, si la tabla esta con datos se eliminan
     *
     */

     public function analisisPendientes(Request $request)
     {
       $user = Auth::id();
       $control = time();
       $time = Carbon\Carbon::createFromTimestamp($control)->toDateTimeString();
       $start = microtime(true);

       /**
        * Verificando si la tabla esta vacia
        */
        $pendientes = \App\Pending::all();

        if($pendientes->isNotEmpty()){
          //se ejecuta el vaciado e la tabla pending
          $pendientes = "";
          \App\Pending::query()->truncate();
          Log::notice("Ejecutada efectivamente el vaciado de la tabla Pending");
        }


       /**
       * Se agregan los campos dataMiss{x} para evitar errores OffSet en el
       * recorrido de lectura de la libreria PhpSpreadsheet
       *-----------------------------------------------------------------------
       * es necesario crear la migracion para modificar la tabla service para
       * produccion
       */

       $cabecera = array(
           "Tecnico",
           "Numero_Orden",
           "Tipo_Orden",
           "SubTipo_Orden",
           "Fecha",
           "Estado",
           "Nombre",
           "Direccion",
           "Locacion",
           "Nodo",
           "Ciudad",
           "Region",
           "Codigo_Postal",
           "Telefono",
           "Telefono_movil",
           "Correo_electrenico",
           "Franja_Horaria",
           "Ventana_Servicio",
           "Ventana_Entrega",
           "Inicio",
           "Finalizacion",
           "Inicio_-_Fin",
           "SLA_inicio",
           "SLA_fin",
           "Duracion",
           "Tiempo_viaje",
           "Tipo_Actividad",
           "Nota_Actividad",
           "Numero_Cuenta",
           "Services_List",
           "COD_Amount",
           "Notas_Entrantes",
           "Comentarios_Orden",
           "Comentarios_Contratista",
           "Comentarios_Despacho",
           "Cancellation_Reason",
           "Notas_Cierre",
           "Habilidades_Trabajo",
           "Zona_Trabajo",
           "Razon_Cierre",
           "Razon_No_Realizado",
           "Razon_Suspension",
           "Estado_coordenadas",
           "ID_recurso",
           "dataMiss",
           "dataMiss1",
           "dataMiss2",
           "dataMiss3",
           "dataMiss4"
       );

       $clearString = array("<","!","-",">","'");

       /*
       * Validacion de permisos de usuario
       */

       /*
       * validacion de inputs
       * Hash File
       * Type File
       */
       //validando inputs

       $reglas         = [
                           'file' => 'required'
                         ];

       $mensajes       = [
                           'file.required'   => 'El campo archivo no puede ser vacio',
                         ];

       $validator      = \Validator::make($request->all(),$reglas,$mensajes);

       if ($validator->fails()) {
           return \Redirect::back()
                       ->withErrors($validator)
                       ->withInput($request->all());
       }

       /*
        * Validando el tipo de archivo el tipo de archivo
        */

       $file_type = $request->file('file')->getClientOriginalExtension();

       switch ($file_type) {
           case 'xlsx':
               $setType =  "Xlsx";
               break;
           case 'xls':
               $setType = "Xls";
               break;

           case 'xml':
               $setType = "Xml";
               break;

           case 'ods':
               $setType = "Ods";
               break;

           default:

               //el archivo es una extension invalida sale con aviso al home
               $mensaje = 'warning*El archivo no es una extension valida';
               return \Redirect::back()->withErrors($mensaje);

               break;
       }

       /*
        * Instancia de lector de excel
        */

       $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($setType);

       $reader->setReadDataOnly(true);

       $data = $reader->load($request->file('file'));

       $dataSheet = $data->getActiveSheet();

       foreach ($dataSheet->getRowIterator() as $row) {

           $cellIterator = $row->getCellIterator();
           $cellIterator->setIterateOnlyExistingCells(FALSE);

           $myCells = [];
           $x = 0;

           foreach ($cellIterator as $cell) {

               switch ($cabecera[$x]) {

                   case 'Tecnico':

                       if($cell->getValue() == "Técnico"){

                         $myCells[$cabecera[$x]] = $cell->getValue();

                       }else{

                         $cell = str_replace($clearString, "", $cell->getValue());

                         $myCells[$cabecera[$x]] = $cell;
                       }

                       break;

                   case 'Fecha':

                         /*Verificando la longitud de la fecha para determinar si es manipulada*/

                         /*buscando el delimitador "/" */

                         $delimitador = "/";
                         $pos = strpos($cell->getValue(), $delimitador);

                         if ( $pos === true ) { //Determinado si existe el delimitador para fecha DD/MM/YY

                           $myFecha = str_replace($clearString, "", $cell->getValue()); //se limpia de caracteres que impiden crear la fecha

                           list($dia, $mes, $anho) = explode("/", $cell->getValue());

                           $anho = "20".$anho;

                           $myCells[$cabecera[$x]] = Carbon\Carbon::createFromDate($anho,$mes,$dia,0,0,0); //dd($myCells,"caso1");

                         } elseif ( strlen( $cell->getValue() ) == 10 ) {

                           $myCells[$cabecera[$x]] = $cell->getValue(); //dd($myCells,"caso2");

                         } elseif ( strlen( $cell->getValue() ) > 10) { //longitud del valor de fecha en Excel

                           $myFecha = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cell->getValue());

                           $myCells[$cabecera[$x]] = $myFecha; //dd($myCells,"caso3");

                         }elseif ( strlen( $cell->getValue() ) < 8 && is_numeric($cell->getValue())) { //longitud del valor de fecha en xls - ODS

                           $myFecha = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cell->getValue());

                           $myCells[$cabecera[$x]] = $myFecha; //dd($myCells,"caso4");

                         }else{
                           if ($cell->getValue() == "Fecha") {
                             $myCells[$cabecera[$x]] = $cell->getValue();
                           } else {
                             list($dia, $mes, $anho) = explode("/", $cell->getValue());

                             $anho = "20".$anho;

                             $myCells[$cabecera[$x]] = Carbon\Carbon::createFromDate($anho,$mes,$dia,0,0,0); //dd($myCells,"caso1");
                           }

                           //dd($myCells,"caso5");
                         }

                       break;

                  case 'Numero_Cuenta':
                      $cell = str_replace($clearString, "", $cell->getValue());

                      $myCells[$cabecera[$x]] = $cell;
                  break;

                   default:

                       $myCells[$cabecera[$x]] = $cell->getValue();

                       break;

               }

               $x++;
           }

           //Cada Fila de Excel

           //falta excluir los valores null en el campo numero

           $myRows[] = $myCells;
       }

       /**
        * Carga en la BD
        */

       $timer  = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
       $path   = null;

       foreach ($myRows as $myKey => $myRow) {

           $myRow += ['source'     => $path];
           $myRow += ['created_at' => $timer];
           $myRow += ['updated_at' => $timer];

           if($myRow["Numero_Orden"] == null || $myRow["Fecha"] == "Fecha"){

           }else{

               $op[] = \DB::table('pending')->insert([$myRow]);

           }

       }

       /**
        * Servicio de analisis para busar pendientes que existan en las VGs
        * en un rango de 6 meses
        */

        $estado       = ["Pendiente","Iniciado","Completado"];

        $carbon_now   = \Carbon\Carbon::now();
        $inicio       = $carbon_now->subMonths(6)->toDateTimeString(); //se establece 6 meses por cobertura de garantia
        $fin          = Carbon\Carbon::createFromTimestamp($control)
                      ->toDateTimeString();


        //$pendientes    = \App\Pending::whereIn("Estado", "Pendiente");
        /*$pendientes    = \DB::table('pending')
                      ->whereIn('Estado',$estado)
                      ->get();

        $analisis      = array();
        foreach ($pendientes as $pendiente) {

          $PreCheck[]   = \DB::table('services')
                        ->distinct()
                        ->where('Numero_Orden','=',$pendiente->Numero_Orden)
                        ->whereBetween('Fecha', [$inicio, $fin])
                        ->get(['Numero_Orden','Fecha']);

        }*/
        //SELECT * FROM pending WHERE (Estado="Pendiente" or Estado="Completado" or Estado="Iniciado") and Numero_Orden>0 and Numero_Cuenta in (SELECT DISTINCT Numero_Cuenta from Services where Estado="Completado" and Fecha BETWEEN '20180222' AND '20180822')
        $PreCheck = DB::select("SELECT * FROM pending
                              WHERE (Estado='Pendiente'
                                OR Estado='Completado'
                                OR Estado='Iniciado')
                                AND Numero_Orden > 0
                                AND Numero_Cuenta
                                IN (SELECT DISTINCT Numero_Cuenta
                                  FROM Services
                                  WHERE Estado='Completado'
                                  AND Fecha BETWEEN '".$inicio."' AND '".$fin."')");
        //

       $end           = ceil((microtime(true) - $start));
       $filas         = count($op);
       $filas_full    = count($myRows);
       $mensaje       = 'success*Se han analizado '.$filas.' registros validos de '.$filas_full.' existentes, en '. $end .' segundos';

       //return \Redirect::back()->withErrors($mensaje);

       return view('result3')->with([
           'header'    => "Carga de Archivo para Analizar",
           'mensaje'   => $mensaje,
           'analisis'  => $PreCheck

           ]);

       /*fin de la funcion analisisPendientes*/
     }
}
