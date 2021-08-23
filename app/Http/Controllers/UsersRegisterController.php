<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\UserRegistrationNotification;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UsersRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('api')->only(['update', 'destroy']);
    }

    public function register(UserFormRequest $request)
    {
        $attibutes = $request->only(['name', 'email', 'phone', 'campus_id']);

        $attibutes['password'] = Hash::make($request->password);

        $user = User::create($attibutes);//->sendEmailVerificationNotification();;

        $token = $user->addEmailToken(['token' => Str::random(35)]);

        if($request->hasFile('avatar'))
        {
            $this->storeAvatar($user);
        }

        return response()->json(['status' => 'success'], 200);
    }


    public function update(User $user, UpdateUserRequest $request)
    {
        $user->update($request->only(['name', 'email', 'phone', 'campus_id']));

        if($request->hasFile('avatar'))
        {
            $this->storeAvatar($user);
        }

        return response()->json(['status' => 'success'], 200);
    }


    public function destroy()
    {

        $user = auth()->guard('api')->user();

        if($user->product)
        {
            $user->product->map(function($shopProduct){

                $shopProduct->delete();

            });
        }


        $user->delete();


        return response()->json(['status' => 'deleted'], 200);
    }

}
