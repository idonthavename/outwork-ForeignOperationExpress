<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    protected $table = 'depot';

    protected $guarded = ['id','created_at','updated_at'];
}
