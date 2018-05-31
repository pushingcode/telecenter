<?php

namespace App\Http\Controllers;

use App\Perfil;
use Illuminate\Http\Request;
use Storage;
use Carbon;
use Redirect;
use Auth;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Perfil del administrador activo
        $user = Auth::id();

        $perfil = Perfil::find($user);

        if($perfil == null){

            $mensaje = 'danger*El perfi no existe!!!';
            $viewPerfil = 'crear_perfil';

        }else{
            $perfil = Perfil::where('user_id','=',$user)->get();
            $mensaje = 'succes*El perfil esta creado!!!';
            $viewPerfil = 'actualizar_perfil';
        }

        return view($viewPerfil)
                ->with(['perfil'=>$perfil])
                ->withErrors($mensaje);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = Auth::id();
        $control = time();
        $time = Carbon\Carbon::createFromTimestamp($control)->toDateTimeString();
        $start = microtime(true);

        /*
        * validacion de inputs
        * Hash File
        * Type File
        */
        //validando inputs

        $reglas         = [
                            'cargo' => 'required|string|max:255',
                            'file'  => 'required'
                          ];

        $mensajes       = [
                            'cargo.required'  => 'El campo cargo es obligatorio',
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

        //dd($file_type);

        switch ($file_type) {
            case 'jpg':
                $setType =  "jpg";
                break;
            case 'png':
                $setType = "png";
                break;

            case 'gif':
                $setType = "gif";
                break;
            
            default:

                //el archivo es una extension invalida sale con aviso al home
                $mensaje = 'warning*El archivo no es una extension valida';
                return \Redirect::back()->withErrors($mensaje);

                break;
        }

        $file_hash = md5_file($request->file('file')->getRealPath());

        $manager = Perfil::where('hash','=',$file_hash);

        if ($manager->exists() == true) {
            $mensaje = 'warning*La imagen ya existe en el sistema';

            return \Redirect::back()->withErrors($mensaje);
        }

        $path = $request->file('file')->store('public/photos/'.$control, 'local');
        
        /**
         * Ajustando la direccion del recurso
         * Se elimina de la url la parte publica
         */
        $path = explode("/", $path);
        $path = $path[1]."/".$path[2]."/".$path[3];

        /**
         * Salvando el nuevo perfil
         *
         */
        $perfil = new Perfil;

        $perfil->user_id       = $user;
        $perfil->cargo         = $request->cargo;
        $perfil->foto          = $path;
        $perfil->genero        = $request->genero;
        $perfil->hash          = $file_hash;

        $perfil->save();

        $mensaje = 'succes*Perfil Creado';
        return \Redirect::back()->withErrors($mensaje);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Perfil $perfil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfil)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perfil $perfil)
    {
        //
    }
}
