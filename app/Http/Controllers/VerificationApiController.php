<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use App\User;

class VerificationApiController extends Controller
{
    use VerifiesEmails;


    public function verify(Request $request)
    {
        
        $user = User::findOrFail($request['id']);
     
        $user->upate(['email_verified_at' => now()]);
    
        return response()->json(['status' => 'verified']);
        
    }


    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) 
        {
            return response()->json([ 'status' => 'already verified'], 422);
    
        }
    
        $request->user()->sendEmailVerificationNotification();
       
        
        return response()->json(['status' => 'verified']);
    }
}
