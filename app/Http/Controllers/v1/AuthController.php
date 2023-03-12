<?php

namespace App\Http\Controllers\v1;


use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|email',
            'password'    => 'required',
            'device_type' => 'required|in:web,ios,android',
            'app_version' => 'required',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return [
            'message'      => 'Successfully logged in',
            'access_token' => $user->createToken($request->input('device_type') . '_' . $request->input('app_version'))->plainTextToken,
            'user'         => UserResource::make($user),
        ];
    }
}
