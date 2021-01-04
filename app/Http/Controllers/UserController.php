<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function index() 
    {
        return User::all();
    }

    public function show($id) 
    {
        return User::find($id);
    }

    public function store(UserCreateRequest $request) 
    {
        $user = User::create([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => Hash::make(1234),
        ]);
        
        return response($user, Response::HTTP_CREATED);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);

        $user->update($request->only('firstname','lastname', 'email'));

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function destroy($id) 
    {
        User::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
