<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * @group Authenticating
     * Register a user
     * @bodyParam password_confirmation string required Password confirmation. Example: yaromir228322
     * @response status=201 scenario=success {"Registered successfully"}
     * @response status=422 scenario="validation error" {"message": "The given data was invalid.",
    "errors": {
    "email": [
    "The email has already been taken."
    ]
    }}
     */
    public function register(RegisterFormRequest $request): JsonResponse
    {
        User::create([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        return response()->json('Registered successfully', 201);
    }
}
