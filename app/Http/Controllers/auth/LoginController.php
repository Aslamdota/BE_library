<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function viewLogin(){
        return view('auth.login', ['title' => 'Login Page']);
    }

    public function authenticate(Request $request){
        // return $request;
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('dashboard.admin');
            }
            else{
                Auth::logout();
                return redirect()->route('login.user')->with('error', 'Role tidak ada');
            }

            return back()->withErrors([
                'email' => 'Email atau password salah',
            ])->onlyInput('email');
            
        }
 
        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil logout');
    }

    
}
