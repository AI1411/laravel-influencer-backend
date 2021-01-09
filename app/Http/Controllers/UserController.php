<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        Gate::authorize('view', 'users');

        $users = User::with('role')->paginate(10);

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

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => \Hash::make($request->input('password')),
        ]);

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        Gate::authorize('edit', 'users');
        $user = User::find($id);

        $user->update($request->only(['first_name', 'last_name', 'email', 'role_id']));

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
        $user =  \Auth::user();

        return (new UserResource($user))->additional([
            'data' => [
                'permissions' => $user->permissions(),
            ]
        ]);
    }

    public function updateInfo(Request $request)
    {
        $user = \Auth::user();

        $user->update($request->only('first_name', 'last_name', 'email'));

        return \response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    public function updatePassword(Request $request)
    {
        $user = \Auth::user();

        $user->update([
            'password' => \Hash::make($request->input('password'))
        ]);

        return \response(new UserResource($user), Response::HTTP_ACCEPTED);
    }
}
