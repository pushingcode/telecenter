<?php

namespace App\Http\Middleware;

use Closure;

class CheckDisk
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * public function handle($request, Closure $next)
     * {
     *   return $next($request);
     * }
     */

    public function handle($request, Closure $next)
        {
            $exists = Storage::disk('local')->exists('manifest.txt');
            //dd($exists);

            if($exists == false) {
                //el sistema no se ha inicializado
            } else {
                //el sistema esta inicializado
                //vefificamos si el contenido es el ultimo en la tabla
            }

            return $next($request);
        }


}