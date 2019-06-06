<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyInformation extends Model
{
    protected $table = 'company_information';

    protected $guarded = ['id','created_at','updated_at'];
}
