<?php

namespace App\Services;

use App\Http\Requests\ChangePasswordRequest;
use App\Jobs\PasswordResetJob;
use App\Models\ApiPasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthPasswordService
{
    public function changeToNewPassword(ChangePasswordRequest $request, $client): \Illuminate\Http\JsonResponse
    {
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

    public function sendPasswordResetMail(Request $request, $client, $providerEmail): \Illuminate\Http\JsonResponse
    {
        if($client)
        {
            $gen_token = Str::random(70);

            $token = ApiPasswordReset::create([
                'email' => $client->email,

                'token' => $gen_token,

                $providerEmail => true
            ]);

            PasswordResetJob::dispatch($client, $token);

            return response()->json(['status' => 'Email sent']);
        }

        return response()->json(['status' => 'Email not found'], 404);
    }

    public function reset(Request $request, ApiPasswordReset $token, $client): \Illuminate\Http\JsonResponse
    {
        if ($token) {
            if(!$token->hasExpired) {
                $client->update(['password' => Hash::make($request->password)]);

                $token->update(['hasExpired' => true]);

                return response()->json(['status' => 'new password saved']);
            }

            return response()->json(['status' => 'Operation Aborted! Token has Expired'], 403);
        }

        return response()->json(['status' => 'Token not found'], 401);
    }
}