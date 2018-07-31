<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pending extends Model
{
    //
    protected $table = 'pending';


    protected $dates = [
      'created_at',
      'deleted_at'
    ];
}
