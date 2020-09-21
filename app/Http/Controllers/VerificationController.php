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

      return  $verified_token =  VerifyEmail::where('token', $request->token)->first();


       if($verified_token)
       {
            $user = User::where('user_id', $verified_token->user_id)->first();

            if(!$user->email_verified_at)
            {

                $user->update(['email_verified_at' => now()]);

                $verified_token->delete();

                return response()->json(['message' => 'verified'], 200);

            }else{

                return response()->json(['message' => 'already verified'], 400);

            }

        }

        return response()->json(['message' => 'Token not found'], 401);
    
    }
    
    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail())
        {
        
            return response()->json(["message" => "Email already verified."], 400);
        
        }

        $user = auth()->user();

        $token = $user->emailVerified->update(['token' => Str::random(35)]);

        UserRegistrationJob::dispatch($user, $token);
    
        return response()->json(["message" => 'mail sent']);
    }


    public function send(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        
        // $token  = str_shuffle() // Str::random(20)
    }
}
