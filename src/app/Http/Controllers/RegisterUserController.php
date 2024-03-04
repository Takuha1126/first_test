<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterUserController extends Controller
{
    public function register(Request $request)
    {
        return view('auth.register');
    }

    public function create(Request $request)
    {
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

         $user->notify(new VerifyEmail);

        $request->session()->regenerate();
        return redirect()->route('home')->with('status', '登録が完了しました。');
    }

    
}