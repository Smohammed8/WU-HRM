<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function userLoginView()
    {
        $username = 'username';
        return view('auth.login',compact('username'));
    }
}
