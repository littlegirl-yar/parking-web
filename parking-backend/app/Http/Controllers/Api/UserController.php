<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get me.
     *
     * This endpoint returns information of current authenticated user.
     *
     * @response scenario=success {
    "data": {
    "name": "Yaromir",
    "email": "yaromiradmin@gmail.com"
    }
    }
     * @response status=401 scenario="unauthorized" {"message": "Unauthenticated."}
     * @authenticated
     * @group Authenticating
     */
    public function me(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}
