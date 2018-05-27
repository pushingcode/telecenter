<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Operador extends Model
{
    //
    use HasRoles;
    use SoftDeletes;
    protected $table = 'operador';

    
    protected $dates = [
      'created_at',
      'deleted_at'
    ];
}
