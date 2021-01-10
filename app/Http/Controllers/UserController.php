<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UpdateInofRequest;
use App\Http\Requests\UpdateEmailRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index() 
    {
        return User::paginate();
    }

    public function show($id) 
    {
        return User::find($id);
    }

    public function store(UserCreateRequest $request) 
    {
        $user = User::create($request->only('firstname','lastname', 'email') + [
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

    public function user() 
    {
        return Auth::user();
    }

    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = Auth::user();
        $user->update($request->only('firstname', 'lastname', 'email'));

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(updatePasswordRequest $request)
    {
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return response($user, Response::HTTP_ACCEPTED);
    }
}
