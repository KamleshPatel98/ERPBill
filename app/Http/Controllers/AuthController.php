<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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

        if($request->remember_me == '1'){
            Cache::put('remember_email', $request->email, now()->addDays(30));
        }else{ 
            Cache::forget('remember_email');
        }

        if(Auth::attempt(['email'=>$request->email, 'password' => $request->password])){
            return to_route('auth.dashboard')->with('success', 'Login successful');
        }else{
            return to_route('login')->with('error', 'Invalid password');
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
        return to_route('login')->with('success', 'Logout successful');
    }
}
