<?php

namespace App\Http\Controllers;

use App\Operador;
use Illuminate\Http\Request;

class OperadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return "lista de operadores";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return "form";
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Operador  $operador
     * @return \Illuminate\Http\Response
     */
    public function show(Operador $operador)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Operador  $operador
     * @return \Illuminate\Http\Response
     */
    public function edit(Operador $operador)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Operador  $operador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Operador $operador)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Operador  $operador
     * @return \Illuminate\Http\Response
     */
    public function destroy(Operador $operador)
    {
        //
    }
}
