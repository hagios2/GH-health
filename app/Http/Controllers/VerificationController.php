<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($user_id, Request $request)
    {
        if (!$request->hasValidSignature()) 
        {
            return response()->json(['message' => 'Invalid or Expired URL provided'], 401);
        }
    
        $user = User::findOrFail($user_id);
    
        if (!$user->hasVerifiedEmail())
        {
            $user->markEmailAsVerified();
        }
    
        return response()->json(['message' => 'verified'], 200);
    
    }
    
    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail())
        {
        
            return response()->json(["message" => "Email already verified."], 400);
        
        }
    
        auth()->user()->sendEmailVerificationNotification();
    
        return response()->json(["message" => 'mail sent']);
    }
}
