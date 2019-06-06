<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sender extends Model
{
    protected $table = 'sender';

    protected $fillable = ['uid','name','phone','country','province','city','address','code'];
}
