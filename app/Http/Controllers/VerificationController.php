<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Jobs\UserRegistrationJob;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {    
       return $user = auth()->guard('api')->user();

        if(!$user->email_verified_at)
        {
            $verified_token = $user->emailVerified->where('token', $request->token)->first();

            if($verified_token)
            {
                $user->update(['email_verified_at' => now()]);

                return response()->json(['message' => 'verified'], 200);

            }else{

                return response()->json(['message' => 'Token not found'], 401);
            }

        }
    
        return response()->json(['message' => 'already verified'], 400);
    
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
