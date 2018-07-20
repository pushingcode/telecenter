<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon;

class ServiceFixYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:year {year*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repara errores de fechas existentes en la BD';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $years = $this->arguments();
        if ($this->confirm("Seguro que desea cambiar las fechas del año "  . $years['year'][0] . " a " . $years['year'][1])) {
          $this->info("Ejecutando!!!!");
          $aritmetica = $years['year'][1] - $years['year'][0];
          $this->info("Se ajustaran "  . $aritmetica .  " año(s) a los registros que salgan afectados");
          //consulta de registros cuyo año esta en la fecha a cambiar

          $count = \DB::table('services')
                  ->whereYear('fecha', '=', $years['year'][0])
                  ->get();

          $cuenta = count($count);

          if ($cuenta == 0) {
            $this->error("No existen registros afectables");
          } else {
            $this->info("Se afectaran " . $cuenta . " registros");
            //registrando la barra de progreso
            $bar = $this->output->createProgressBar($cuenta);
            //bucle para recorrer el arreglo cuenta y realizar los cambios necesarios
            foreach ($count as $key => $value) {
              //$this->info($value->id . "-" . $value->Fecha);
              $newDate = Carbon\Carbon::createFromFormat('Y-m-d', $value->Fecha)->addYear($aritmetica);
              //update

              \DB::table('services')
                  ->where('id', '=', $value->id)
                  ->update(['Fecha' => $newDate]);

              $bar->advance();
            }
            $bar->finish();
            $this->info("\nComando ejecutado con exito!!!");
          }

        } else {
          $this->info("Accion terminada por el usuario!!!!");
        }
    }
}
