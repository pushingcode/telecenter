<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatamissToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            //
            $table->text('dataMiss4')->nullable()->after('dataMiss');
            $table->text('dataMiss3')->nullable()->after('dataMiss');
            $table->string('dataMiss2')->nullable()->after('dataMiss');
            $table->string('dataMiss1')->nullable()->after('dataMiss');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            //
        });
    }
}
