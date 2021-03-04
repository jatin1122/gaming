<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrentUserResource;
use App\User;

class UserController extends Controller
{
    public function getCurrentUser(Request $request)
    {
        return new CurrentUserResource($request->user());
    }

    public function getUser($userId)
    {
        return new UserResource(User::findOrFail($userId));
    }
}
