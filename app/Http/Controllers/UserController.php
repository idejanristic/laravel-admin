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
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index() 
    {
        Gate::authorize('view', 'users');

        $users = User::paginate();

        return UserResource::collection($users);
    }

    public function show($id) 
    {
        Gate::authorize('view', 'users');

        $user = User::find($id);

        return new UserResource($user);
    }

    public function store(UserCreateRequest $request) 
    {
        Gate::authorize('edit', 'users');

        $user = User::create($request->only('firstname','lastname', 'email', 'role_id') + [
            'password' => Hash::make(1234),
        ]);
        
        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        Gate::authorize('edit', 'users');

        $user = User::find($id);

        $user->update($request->only('firstname','lastname', 'email', 'role_id'));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    public function destroy($id) 
    {
        Gate::authorize('edit', 'users');

        User::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function user() 
    {
        $user = Auth::user();

        return (new UserResource($user))->additional([
            'data' => [
                'permissions' => $user->permissions(),
            ]
        ]);
    }

    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = Auth::user();
        $user->update($request->only('firstname', 'lastname', 'email'));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    public function updatePassword(updatePasswordRequest $request)
    {
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }
}
