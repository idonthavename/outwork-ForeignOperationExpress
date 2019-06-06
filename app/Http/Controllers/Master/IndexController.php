<?php

namespace App\Http\Controllers\Master;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    private $output;

    public function index(){
        $user = Auth::user();
        $this->output['user'] = $user;
        return view('master.index',$this->output);
    }
}
