<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function register(UserRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create($validatedData);

        $token = JWTAuth::fromUser($user);

        if (!$token) {
            return $this->apiResponse(null, 'Unauthorized', 404);
        }

        return $this->apiResponse(UserResource::make($user)->additional(['token' => $token]), 'User registered successfully', 201);
    }
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {

            return $this->apiResponse(null, 'Unauthorized', 404);
        }
        return $this->apiResponse($token, 'User logged in successfully', 201);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function userList()
    {
        $users = User::all();
        return $this->apiResponse(UserResource::collection($users), 'User List', 200);
    }

    public function updateProfile(UserRequest $request)
    {
        $user = auth()->user();

        $user->update($request->validated());

        return $this->apiResponse(
            UserResource::make($user),
            'User profile updated successfully.',
            200
        );
    }
    public function userProfile()
    {

        return $this->apiResponse(UserResource::make(auth()->user()), 'User profile retrieved successfully.', 200);

    }

    public function destroy()
    {
        $user = auth()->user();

        $user->delete();
        auth()->logout();

        return $this->apiResponse([], 'User deleted successfully.', 200);
    }
}
