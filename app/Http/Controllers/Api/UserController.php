<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::get();
        $collect = new UserCollection($user);
        return response()->json([
            'data' => $collect
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user)
    {
        $validate = [
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password')
        ];
        $user->update($validate);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if($user->where('email', $user->email))
        {
            $user->tokens()->delete();
            $user->delete();
        }
        return response()->json([
            'data' => $user,
            'message' => 'User has been deleted'
        ]);
    }
}
