<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
           $table->string('Tecnico')->nullable();
            $table->string('Numero_Orden')->nullable();
            $table->string('Tipo_Orden')->nullable();
            $table->string('SubTipo_Orden')->nullable();
            $table->date('Fecha');
            $table->string('Estado')->nullable();
            $table->string('Nombre')->nullable();
            $table->string('Direccion')->nullable();
            $table->string('Locacion')->nullable();
            $table->string('Nodo')->nullable();
            $table->string('Ciudad')->nullable();
            $table->string('Region')->nullable();
            $table->string('Codigo_Postal')->nullable();
            $table->string('Telefono')->nullable();
            $table->string('Telefono_movil')->nullable();
            $table->string('Correo_electrenico')->nullable();
            $table->string('Franja_Horaria')->nullable();
            $table->string('Ventana_Servicio')->nullable();
            $table->string('Ventana_Entrega')->nullable();
            $table->string('Inicio')->nullable();
            $table->string('Finalizacion')->nullable();
            $table->string('Inicio_-_Fin')->nullable();
            $table->string('SLA_inicio')->nullable();
            $table->string('SLA_fin')->nullable();
            $table->string('Duracion')->nullable();
            $table->string('Tiempo_viaje')->nullable();
            $table->string('Tipo_Actividad')->nullable();
            $table->string('Nota_Actividad')->nullable();
            $table->string('Numero_Cuenta');
            $table->string('Services_List')->nullable();
            $table->string('COD_Amount')->nullable();
            $table->text('Notas_Entrantes')->nullable();
            $table->text('Comentarios_Orden')->nullable();
            $table->text('Comentarios_Despacho')->nullable();
            $table->text('Cancellation_Reason')->nullable();
            $table->text('Notas_Cierre')->nullable();
            $table->text('Habilidades_Trabajo')->nullable();
            $table->string('Zona_Trabajo')->nullable();
            $table->text('Razon_Cierre')->nullable();
            $table->text('Razon_No_Realizado')->nullable();
            $table->text('Razon_Suspension')->nullable();
            $table->string('Estado_coordenadas')->nullable();
            $table->string('ID_recurso')->nullable();
            $table->string('dataMiss')->nullable();
            $table->string('source')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
