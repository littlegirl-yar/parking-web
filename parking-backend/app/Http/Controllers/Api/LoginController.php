<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TokenFormRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Get a token.
     *
     * This endpoint is needed to authenticate user (Laravel Sanctum).
     *
     * @response scenario=success {"access_token": "51|G6uNN3kQmAiTcbQOOz47XjEBCFKJ61nPYzjwdOoC","token_type": "Bearer"}
     * @response status=422 scenario="validation error" {
     * "message": "The given data was invalid.",
     * "errors": {
     * "email": [
     * "The email field is required."]}}
     *
     * @group Authenticating
     */
    public function token(TokenFormRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request->get('email'))->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer'
        ]);
    }
    /**
     * Log out a user.
     * @response scenario=success {"Logged out"}
     * @response status=401 scenario="unauthorized" {"message": "Unauthenticated."}
     * @authenticated
     * @group Authenticating
     */
    public function logout(Request $request) : JsonResponse
    {
        Auth::guard('web')->logout();

        $request->user()->currentAccessToken()->delete();

        return response()->json('Logged out',200);
    }
}
