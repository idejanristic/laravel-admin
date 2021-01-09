<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt($request->only('email', 'password')))
        {
            $user = Auth::user();

            $token = $user->createToken('admin')->accessToken;

            return [
                'token' => $token,
            ];
        }

        return response([
            'error' => 'Invalid Credentials',
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->only('firstname','lastname', 'email') + [
            'password' => Hash::make(1234),
        ]);
        
        return response($user, Response::HTTP_CREATED);
    }
}
