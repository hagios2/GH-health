<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Jobs\UserRegistrationJob;
use App\VerifyEmail;


class VerificationController extends Controller
{
    public function verify(Request $request)
    {    

       $verified_token =  VerifyEmail::where('token', $request->token)->first();


       if($verified_token)
       {
            $user = User::where('id', $verified_token->user_id)->first();

            if(!$user->email_verified_at)
            {

                $user->update(['email_verified_at' => now()]);

                // $verified_token->delete();

                return response()->json(['message' => 'verified'], 200);

            }else{

                return response()->json(['message' => 'already verified'], 400);

            }

        }

        return response()->json(['message' => 'Token not found'], 401);
    
    }
    
    public function resend(Request $request)
    {
        
        $user = User::where('email', $request->email)->first();

        if(!$user->email_verified_at)
        {

            $verified_token =  VerifyEmail::where('user_id', $user->id)->first();

            $verified_token->update(['token' => Str::random(35)]);
    
            UserRegistrationJob::dispatch($user, $verified_token);
        
            return response()->json(["message" => 'mail sent']);
        }

        return response()->json(["message" => 'email already verified']);
    
    }


    public function send(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        
        // $token  = str_shuffle() // Str::random(20)
    }
}
