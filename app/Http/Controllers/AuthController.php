<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt([
            'email'=>$request->get('email'),
            'password'=>$request->get('password')
        ])){
            $token=Auth::user()->createToken('myToken'.Auth::user()->id)->plainTextToken;
            $user = Auth::user();
            return \response(['user'=> $user->loadMissing(['plan', 'firstMediaOnly']),'token'=>$token]);
        }

        else {
            return \response('error with the email or password', 401);
        }
    }

    public function logout()
    {
        return auth()->user()->tokens()->delete();
    }
}
