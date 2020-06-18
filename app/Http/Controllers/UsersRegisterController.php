<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Jobs\UserRegistrationJob;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class UsersRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('api')->only('update');
    }

    public function register(UserFormRequest $request)
    {
        $attibutes = $request->only(['name', 'email', 'phone', 'campus_id']);

        $attibutes['password'] = Hash::make($request->password);

        $user = User::create($attibutes);

        if($request->hasFile('avatar'))
        {
            $this->storeAvatar($user);
        }


/*         $user->notify(new UserRegistrationNotification($user)); */

        return response()->json(['status' => 'success'], 200);
    }


    public function storeAvatar(User $user)
    {
        $file = request()->file('avatar');

        $fileName = $file->getClientOriginalName();

        $file->storeAs('public/avatar/'.$user->id, $fileName);

        $user->update(['avatar' => storage_path('app/public/avatar/'.$user->id.'/'.$fileName)]);
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

}
