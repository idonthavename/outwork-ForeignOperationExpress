<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $table = 'line';

    protected $guarded = ['id','created_at','updated_at'];
}
