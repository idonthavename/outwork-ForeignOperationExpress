<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product';

    protected $guarded = ['id','created_at','updated_at'];

    public function categoryOne(){
        return $this->hasOne('App\Product','id','category_one');
    }

    public function categoryTwo(){
        return $this->hasOne('App\Product','id','category_two');
    }
}
