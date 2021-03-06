<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $guarded = ['id','money','created_at','updated_at'];

    public function lineData(){
        return $this->hasOne('App\Line','id','line_id');
    }

    public function linetwoData(){
        return $this->hasOne('App\Linetwo','id','linetwo');
    }

    public function userData(){
        return $this->hasOne('App\User','id','uid');
    }

    public function productData(){
        return $this->hasMany('App\OrderProduct','system_order_no','system_order_no');
    }
}
