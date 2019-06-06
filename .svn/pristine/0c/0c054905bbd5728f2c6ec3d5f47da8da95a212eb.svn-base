<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'email', 'password','mobile','xing','ming','user_identification'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function personalData(){
        return $this->hasOne('App\PersonalInformation','uid','id');
    }

    public function companyData(){
        return $this->hasOne('App\CompanyInformation','uid','id');
    }
}
