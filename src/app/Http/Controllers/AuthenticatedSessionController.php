<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;
use App\Models\Address;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    public function login() {
        $user = Auth::user();
        return view('auth.login');
    }
    public function store(LoginRequest $request) {
        $user = Auth::user()->name;
        $email = $request->input('email');
        $password = $request->input('password');
        $hashedPassword = Auth::where('email', $email)->first();
         return view('auth.login');


        if($hashedPassword && Hash::check($password, $hashedPassword->password)){
        return view('index');
        }else{
            return view('auth.login');
        }
    }
       

    public function destroy(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home');

    }
}
