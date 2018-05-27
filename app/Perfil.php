<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Perfil extends Model
{
    //
    use SoftDeletes;
    protected $table = 'perfils';

    
    protected $dates = [
      'created_at',
      'deleted_at'
    ];
}
