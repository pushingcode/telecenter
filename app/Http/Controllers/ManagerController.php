<?php

namespace App\Http\Controllers;

use App\Manager;
use App\Services;
use Illuminate\Http\Request;
use Storage;
use Carbon;
use Redirect;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        /**
        * Listamos todos los elementos que estan en la tabla Manager
        * Se valida que el recurso existe en el disco y que esta disponible -
        * para descarga
        */

        // TODO:
        // Contador de descargas para el recurso
        // Agregar el tipo de archivo que esta guardado

        /**
        * Consulta de tabla Manager
        */

        $recursos = Manager::all();

        //Segun la cantidad enviamos a una vista con paginacion de > a 15
        $cantidad = $recursos->count();

        //buscamos en la tabla servicio para obtener una referencia de los Datos
        //que existen en el archivo a descargar
        foreach ($recursos as $recurso) {
          $RefInicio[$recurso->id] = Services::where('source', $recurso->manifest)->first()->Fecha;
          $RefFinal[$recurso->id] = Services::where('source', $recurso->manifest)->orderBy('id', 'desc')->first()->Fecha;
        }

        /*dd(
          $recursos,
          $cantidad,
          $RefInicio,
          $RefFinal
        );*/

        if ($cantidad > 15) {
          $vista = 'archivos';
        }else{
          $vista = 'archivo';
        }

        return view($vista)->with([
            'recursos'  => $recursos,
            'header'    => "Descarga de Archivo de Servicio",
            'inicio'    => $RefInicio,
            'fin'       => $RefFinal
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('upload')->with([
            'header'    => "Carga de Archivo de Servicio"
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::id();
        $control = time();
        $time = Carbon\Carbon::createFromTimestamp($control)->toDateTimeString();
        $start = microtime(true);

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
            "dataMiss"
        );

        $clearString = array("<","!","-",">");

        //dd($cabecera);

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

        /**
        * Inicio de validacion de archivo exista en el sistema
        *
        */

        $file_hash = md5_file($request->file('file')->getRealPath());

        $manager = Manager::where('hash','=',$file_hash);

        if ($manager->exists() == true) {
            $mensaje = 'warning*El archivo ya existe en el sistema con el hash '. $file_hash;

            return \Redirect::back()->withErrors($mensaje);
        }

        $path = $request->file('file')->store('files/'.$control, 'local');

        /**
        * Fin de validacion de archivo exista en el sistema
        *
        */

        /*
         * Gestion de archivo y carga en la BD
         * Consideraciones:
         * La Fecha deba estar guardada en el archivo bajo la expresion "Fecha[espacio][MM/DD/YYYY]"
         * La construccion de fechas depende de lo anterior (esctricto)
         * El campo Tecnico es limpiado de la siguiente expresion ("<!->")
         * El campo Numero_Orden con valores NULL es excluido de la pila de consultas de incersion
         * La prueba de esfuerzo hasta el momento de 200 registros con 20MB de memoria asignados en PHP.INI
         * La prueba de esfuerzo hasta el 30/06/2018 de 200 registros con 1024MB de memoria asignados en PHP.INI
         */



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

                        $cell = str_replace($clearString, "", $cell->getValue());

                        $myCells[$cabecera[$x]] = $cell;

                        break;

                    case 'Fecha':

                        $myFecha = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cell->getValue());

                        $myCells[$cabecera[$x]] = $myFecha;

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
         * Validacion de numero de orden preexistente en la bd
         */

        foreach ($myRows as $key => $value) {

          //$validaOrden = Services::where('Numero_Orden','=',$value["Numero_Orden"]);

          $validaOrden = Services::where([
              ['Numero_Orden','=',$value["Numero_Orden"]],
              ['Estado','=','Completado']
            ]);

          //dd($validaOrden);

          if ($validaOrden->exists() == true) {
              $mensaje = 'warning*El archivo posee informacion ya registrada, para evitar duplicidad se aborta la operacion';

              return \Redirect::back()->withErrors($mensaje);
          }
        }

        /**
         * Carga en la BD
         */

        foreach ($myRows as $myKey => $myRow) {

            $myRow += ['source'=>$path];

            if($myRow["Numero_Orden"] == null){

            }else{

                $op[] = \DB::table('services')->insert([$myRow]);

            }

        }

        /*
         **FIN**
         */

         /**
         * Inicio manejo del archivo al disco local
         */

         Storage::put('manifest.txt', $path);

         $manager = new Manager;

         $manager->user_id       = $user;
         $manager->manifest      = $path;
         $manager->last_modified = $time;
         $manager->hash          = $file_hash;

         $manager->save();

         /**
         * Fin manejo del archivo al disco local
         */

        /*estadisticas*/

        $end = ceil((microtime(true) - $start));

        $filas = count($op);
        $filas_full = count($myRows);
        $mensaje = 'success*Se han cargado '.$filas.' registros validos de '.$filas_full.' existentes, en '. $end .' segundos';

        return \Redirect::back()->withErrors($mensaje);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function show(Manager $manager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function edit(Manager $manager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manager $manager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manager $manager)
    {
        //
    }

    /**
     * verificamos si se ha inicializado el sistema
     *
     * @param  \App\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function checkDisk()
    {
        $disk = 'local';
        $time = "";
        $content = "";
        $manager = [];
        $mensaje = 'info*El sistema no se ha iniciado';
        $file_size = 0;
        $directory = dirname(__DIR__, 3).'/storage/app/files/';
        $porcentaje_disco = 0;
        $limit  =  1024;

        $exists = Storage::disk($disk)->exists('manifest.txt');
        //dd($exists);

        if ($exists == true) {

            $time = Storage::lastModified('manifest.txt');
            $time = Carbon\Carbon::createFromTimestamp($time)->toDateTimeString();

            //leemos el archivo y validamos
            $content = Storage::get('manifest.txt');

            if(empty($content)){
                $mensaje = 'info*El sistema fue inicializado el '. $time;
            } else {

                foreach( \File::allFiles($directory) as $file){
                    $file_size += $file->getSize();

                }

                $dirSize = number_format($file_size / 1048576,2);

                $porcentaje_disco = ceil(($dirSize * 100)/$limit);

                //consultamos la tabla Manifiesto
                $manager = Manager::where([
                    ["manifest","=",$content],
                    ["last_modified","=",$time]]);

                if ($manager->count() == 0) {
                    $mensaje = 'danger*Error en el sistema el inventario de control en BD, no coincide con la exixtencia en disco';
                } else {
                    $mensaje = 'success*Disco '.$disk.' OK!!!';
                }
            }

        }

        //return \Redirect::back()->withErrors($mensaje);
        return view('disk')
                ->with(['porcentajes'=>$porcentaje_disco,
                        'header'=>"Administracion del Disco Local",
                        'disco'=>$directory,
                        'size'=>$limit])
                ->withErrors($mensaje);
    }

    /**
     * Creando usuarios fuera del middleware Auth
     *
     * @param  \App\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function user_register(Request $request)
    {
        //validacion de usuario
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return \Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }

        /*
        * registro de usuario *
        */

        $timer = \Carbon\Carbon::now()->format('Y-m-d H:i:s');

        $id = \DB::table('users')
                ->insertGetId([
                   'name'           => $request->name,
                   'email'          => $request->email,
                   'password'       => bcrypt($request->password),
                   'created_at'     => $timer,
                   'updated_at'     => $timer,
               ]);

        /*
        * Asignando roles de Administrador *
        */

        $user = \App\User::find($id);

        $user->assignRole('admin');

        $mensaje = 'success*Nuevo usuario creado!!!';

        return view('auth.register')
                ->with([
                        'header'=>"Creacion de Usuarios"
                        ])
                ->withErrors($mensaje);
    }

    /**
     * donwload the specified resource from storage.
     *
     * @param  \App\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function donwload(Manager $id)
    {
        //
        if($id->count() == 0){
          $mensaje = 'info*El recurso solicitado no existe!!!';
          return \Redirect::back()
                      ->withErrors($mensaje);
        }

          return Storage::download($id->manifest,'EpicaNero'.$id->created_at.'['.$id->id.'].xlsx');
    }
}
