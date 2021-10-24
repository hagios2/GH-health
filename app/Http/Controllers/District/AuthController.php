<?php

namespace App\Http\Controllers\District;

use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictAuthResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:district_admin', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {

        $credentials = request(['email', 'password']);

        $credentials['isActive'] = true;

        if (! $token = auth()->guard('district_admin')->attempt($credentials)) {

            return response()->json(['error' => 'Unauthorized'], 401);
        }

        /*    Admin::where('email', request()->email) */
        auth()->guard('district_admin')->user()->update(['last_login', now()]);

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return DistrictAuthResource
     */
    public function getAuthUser()
    {
        return new DistrictAuthResource(auth()->guard('district_admin')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->guard('district_admin')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->guard('district_admin')->refresh());
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
            'expires_in' => auth()->factory()->getTTL(),
            'statusCode' => 200
        ]);
    }


    public function sendShopResetMail(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        $shop = Merchandiser::where('email', $request->email)->first();

        if($shop)
        {
            $gen_token = Str::random(70);

            $token = ApiPasswordReset::create([

                'email' => $shop->email,

                'token' => $gen_token,

                'isAdminEmail' => true
            ]);

            //Mail::to($client)->send(new ClientPasswordResetMail($client, $token));
            ShopPasswordResetJob::dispatch($shop, $token);

            return response()->json(['status' => 'Email sent']);
        }

        return response()->json(['status' => 'Email not found'], 404);
    }

}
