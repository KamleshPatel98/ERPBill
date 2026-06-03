<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('panel.auth.login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
        ]);

        if(Auth::attempt(['email'=>$request->email, 'password' => $request->password])){
            return to_route('auth.dashboard');
        }else{
            return to_route('login');
        }
    }

    public function dashboard()
    {
        return view('panel.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return to_route('login');
    }
}
