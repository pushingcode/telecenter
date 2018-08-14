<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon;

class CheckGarantias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:garantias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificacion de garantias en base a los registros existentes en la tabla Pending';

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
        $this->info("Verificamos la tabla pending para ver si exsisten registros");
        $control      = time();
        $estado       = ["Pendiente","Iniciado"];
        $carbon_now   = \Carbon\Carbon::now();
        $inicio       = $carbon_now->subMonths(6)->toDateTimeString(); //se establece 6 meses por cobertura de garantia
        $fin          = Carbon\Carbon::createFromTimestamp($control)
                      ->toDateTimeString();
        $i            = 1;


        $pendientes    = \DB::table('pending')
                      ->whereIn('Estado',$estado)
                      ->get();

        $cuenta = count($pendientes);

        if ($cuenta == 0) {
          $this->error("No existen registros afectables");
        } else {
          $this->info("Se encuentran (" . $cuenta . ") registros que pudieran arrojar garantia");


          foreach ($pendientes as $pendiente) {

            $PreCheck[]   = \DB::table('services')
                          ->distinct()
                          ->where('Numero_Orden','=',$pendiente->Numero_Orden)
                          ->whereBetween('Fecha', [$inicio, $fin])
                          ->get(['Numero_Orden','Numero_Cuenta','Fecha']);

          }

          foreach ($PreCheck as $check) {

            foreach ($check as $value) {
              $this->info("|" . $i . "|" . $value->Numero_Orden . " | " . $value->Numero_Cuenta . " | " . $value->Fecha . " | ");
              $i++;
            }

          }

        }
    }
}