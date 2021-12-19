<?php

namespace App\Http\Controllers;

use App\Mail\MerchandiserPasswordResetMail;
use App\Models\ApiPasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\PasswordResetJob;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePasswordRequest;

class PasswordResetController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth:api', ['only' => ['changeUserPassword', 'changeMediaPassword']]);

    }

    public function changeUserPassword(ChangePasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $client = auth()->guard('api')->user();

        if(Hash::check($request->password, $client->password))
        {
            if($request->password == $request->new_password)
            {
                return response()->json(['status' => 'Password is already in use']);

            }else{

                $client->update(['password' => Hash::make($request->new_password)]);

                return response()->json(['status' => 'password changed']);
            }

        }

        return response()->json(['status' => 'invalid Password']);
    }


    public function changeShopPassword(ChangePasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $shop = auth()->guard('merchandiser')->user();

        if(Hash::check($request->password, $shop->password))
        {
            if($request->password == $request->new_password)
            {
                return response()->json(['status' => 'Password is already in use']);

            }else{

                $shop->update(['password' => Hash::make($request->new_password)]);

                return response()->json(['status' => 'password changed']);
            }

        }

        return response()->json(['status' => 'invalid Password']);
    }

    public function adminSendRequest(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }


    public function sendResetMail(Request $request): \Illuminate\Http\JsonResponse
    {

        $request->validate(['email' => 'required|email']);

        $client = User::query()->where('email', $request->email)->first();

        if($client)
        {
            $gen_token = Str::random(70);

            $token = ApiPasswordReset::create([
                'email' => $client->email,

                'token' => $gen_token,

                'isUserEmail' => true
            ]);

            //Mail::to($client)->send(new ClientPasswordResetMail($client, $token));
            PasswordResetJob::dispatch($client, $token);

            return response()->json(['status' => 'Email sent']);
        }

        return response()->json(['status' => 'Email not found'], 404);
    }


    public function sendShopResetMail(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        $shop = Merchandiser::where('email', $request->email)->first();

//        Log::info($shop);

        if($shop)
        {
            $merchandiser = $shop;

            $gen_token = Str::random(70);

            $token = ApiPasswordReset::create([

                'email' => $shop->email,

                'token' => $gen_token,

                'isMediaEmail' => true
            ]);

//            ShopPasswordResetJob::dispatch($shop, $token);
            Mail::to($shop->email)->queue(new MerchandiserPasswordResetMail($merchandiser, $token));

            return response()->json(['status' => 'Email sent']);
        }

        return response()->json(['status' => 'Email not found'], 404);
    }



    public function reset(Request $request): \Illuminate\Http\JsonResponse
    {
        $token = ApiPasswordReset::where([['token', $request->token], ['isUserEmail', true]])->first();

        if($token)
        {

            if(!$token->hasExpired)
            {
                $client = User::where('email', $token->email)->first();

                $client->update(['password' => Hash::make($request->password)]);

                $token->update(['hasExpired' => true]);

                return response()->json(['status' => 'new password saved']);
            }

            return response()->json(['status' => 'Operation Aborted! Token has Expired'], 403);
        }

        return response()->json(['status' => 'Token not found']);
    }



    public function shopReset(Request $request)
    {
        $token = ApiPasswordReset::where([['token', $request->token], ['isMediaEmail', true]])->first();

        if($token)
        {

            if(!$token->hasExpired)
            {
                $shop = Merchandiser::where('email', $token->email)->first();

                $shop->update(['password' => Hash::make($request->password)]);

                $token->update(['hasExpired' => true]);

                return response()->json(['status' => 'new password saved']);
            }

            return response()->json(['status' => 'Operation Aborted! Token has Expired'], 403);
        }

        return response()->json(['status' => 'Token not found']);
    }
}
