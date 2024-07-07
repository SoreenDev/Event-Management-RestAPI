<?php

namespace App\Http\Controllers;

use App\Http\Middleware\ValidateSignature;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\ValidationException;
use PharIo\Manifest\Extension;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->validated();

        $user = User::where('email',$request->email)->first();

        if (! $user)
        {
            throw ValidationException::withMessages([
               'email' => 'the provided credentials incorect . '
            ]);
        }elseif ( ! Hash::check($request->password,$user->password) )
        {
            throw ValidationException::withMessages([
                'password' => 'the provided credentials incorect . '
            ]);
        }
        $token = $user->CreateToken('api-token')->plainTextToken;

        # in another way

//        if (Auth::attempt($request->validated())){
//            $user = Auth::user();
//            $token = $user->CreateToken('api-token')->plainTextToken;
//        }

        return response()->json([
            'token' => $token ?? 'faild'
        ]);
    }
}

