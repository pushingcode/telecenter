<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfils', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('cargo');
            $table->string('foto');
            $table->enum('genero', ['M', 'F', 'I']);
            $table->string('hash');
            $table->timestamps();
        });

        Schema::table('perfils', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('perfils', function ($table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfils');
    }
}
