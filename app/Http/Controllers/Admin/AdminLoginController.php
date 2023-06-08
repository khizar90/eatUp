<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminLoginController extends Controller
{
    public function loginPage(){
        return view('login');
    }

    public function login(Request $request){
        $request->validate(
            [
                'username' => 'required|exists:admins,username',
                'password' => 'required',

            ]
        );
        
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('home');
        }
        
        return redirect()->back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('loginPage');
    }
    

    
}
