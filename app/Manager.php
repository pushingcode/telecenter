<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    //
    protected $table = 'manager';

    protected $dates = [
      'last_modified',
      'created_at',
      'deleted_at'
    ];
}
