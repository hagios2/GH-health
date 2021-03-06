<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Resources\AdminAuthResource;

class AuthController extends Controller
{
        /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(): \Illuminate\Http\JsonResponse
    {

        $credentials = request(['email', 'password']);

        $credentials['isActive'] = true;

        if (! $token = auth()->guard('admin')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

     /*    Admin::where('email', request()->email) */
        auth()->guard('admin')->user()->update(['last_login', now()]);

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return AdminAuthResource
     */
    public function getAuthUser(): AdminAuthResource
    {
        return new AdminAuthResource(auth()->guard('admin')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->guard('admin')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(): \Illuminate\Http\JsonResponse
    {
        return $this->respondWithToken(auth()->guard('admin')->refresh());
    }

      /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 3600,
            'statusCode' => 200
        ]);
    }


    public function updateProfile(UpdateUserRequest $request): \Illuminate\Http\JsonResponse
    {
        auth()->guard('admin')->user()->update($request->validated());

        return response()->json(['message' => 'Profile Updated']);
    }
}
