<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Perfil;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::id();

        $perfil = Perfil::find($user);

        if($perfil == null){

            $mensaje    = 'danger*El perfi no existe!!!';
            $viewPerfil = 'crear_perfil';

        }else{
            $perfil     = Perfil::where('user_id','=',$user)->get();
            $mensaje    = 'succes*El perfil esta creado!!!';
            $viewPerfil = 'actualizar_perfil';
        }

        return view('home')->with([
            'perfil'    => $perfil,
            'header'    => "Estadisticas"
            ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('auth.register')->with([
            'header'    => "Registro de Usuario"
            ]);
    }
}
