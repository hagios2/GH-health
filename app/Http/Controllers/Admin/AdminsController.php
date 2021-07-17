<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserFormRequest;
use App\Mail\UserRegistrationMail;
use App\Models\User;
use App\Http\Resources\AdminViewUsersResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function getUsers()
    {
        return new AdminViewUsersResource(User::query()->paginate(10));
    }

    public function createFacilitator(UserFormRequest $request)
    {
        $user_data = $request->validated();

        $password = Str::random(8);

        $user_data['password'] = Hash::make($password);

        $user = User::create($user_data);

        if($request->hasFile('avatar'))
        {
            $this->storeAvatar($user);
        }

        Mail::to($user)->queue(new UserRegistrationMail($user, $password));

        return response()->json(['message' => 'facilitator created'], 201);
    }

    public function updateFacilitator(User $user, UpdateUserRequest $request)
    {
        $user->update($request->validated());

        if($request->hasFile('avatar'))
        {
            $this->storeAvatar($user);
        }

        return response()->json(['message' => 'facilitator updated']);
    }

    public function blockUser(User $user)
    {
       $user->update(['isActive' => false]);

       return response()->json(['message' => 'blocked']);
    }


    public function unblockUser(User $user)
    {

       $user->update(['isActive' => true]);

       return response()->json(['message' => 'unblocked']);

    }

    public function deleteFacilitator(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'unblocked']);

    }

}
