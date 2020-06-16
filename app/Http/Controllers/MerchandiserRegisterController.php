<?php

namespace App\Http\Controllers;


use App\Merchandiser;
use Illuminate\Http\Request;
use App\Http\Requests\MerchandiserFormRequest;
use App\Http\Requests\UpdateMerchandiserRequest;
use Illuminate\Support\Facades\Hash;


class MerchandiserRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:merchander')->only('update');
    }

    public function register(MerchandiserFormRequest $request)
    {
        $attributes = $request->only(['company_name', 'email', 'phone', 'company_description', 'campus_id']);

        $attributes['password'] = Hash::make($request->password);

        $merchandiser = Merchandiser::create($attributes);

        $this->storeAvatar($merchandiser);
        
            /* $merchandiser->notify(new UserRegistrationNotification()); */

        return response()->json(['status' => 'success'], 200);
    }


    public function storeAvatar(Merchandiser $merchandiser)
    {
        $file = request()->file('avatar');

        $fileName = $file->getClientOriginalName();

        $file->storeAs('public/avatar/'.$merchandiser->id, $fileName);

        $merchandiser->update(['avatar' => storage_path('app/public/avatar/'.$merchandiser->id.'/'.$fileName)]);
    }

    
    public function update(Merchandiser $merchandiser, UpdateMerchandiserRequest $request)
    {
        $merchandiser->update($request->only(['company_name', 'email', 'phone', 'company_description']));

        if($request->hasFile('avatar'))
        {
            $this->storeAvatar($merchandiser);   
        }

        return response()->json(['status' => 'success'], 200);
    }   
}
