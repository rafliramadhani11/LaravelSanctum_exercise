<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'data' => $user,
            'token' => $user->createToken('token')->plainTextToken,
            'message' => "You're Logged in"
        ]);
    }

    public function logout(User $user)
    {
        $user->tokens()->delete();
        return response()->json([
            'name' => $user->name,
            'message' => "You're Loggout"
        ]);
    }

    public function register(Request $request)
    {
        // HASH PASSWORD
        $request['password'] = bcrypt(request('password'));
        // VALIDATE REQUEST
        $validated = $request->validated();

        // CREATE NEW USER
        User::create($validated);
        return response()->json([
            'user' => $request->all(),
            'message' => 'Successed make new User',
        ]);
    }
}
