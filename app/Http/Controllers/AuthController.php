<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function ShowLogin(){
        return view('auth.login');
    }
    public function ShowSignup(){
        return view('auth.login');
    }


}
