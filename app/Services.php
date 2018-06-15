<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    //
    protected $table = 'services';

    
    protected $dates = [
      'created_at',
      'deleted_at'
    ];
}
