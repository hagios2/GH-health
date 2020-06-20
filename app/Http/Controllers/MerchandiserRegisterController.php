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
        $attributes = $request->validated();

        $attributes['password'] = Hash::make($request->password);

        $merchandiser_id = Merchandiser::create($attributes)->id;
        
            /* $merchandiser->notify(new UserRegistrationNotification()); */

        return response()->json(['status' => 'success', 'merchandiser_id' => $merchandiser_id], 200);
    }


    public function storePhotos(Merchandiser $merchandiser, $file_type)
    {

        if($file_type == 'avatar')
        {
            $file = request()->file('avatar');

        }else if($file_type == 'cover_photo'){

            $file = request()->file('cover_photo');

        }

        $fileName = $file->getClientOriginalName();

        $file->storeAs('public/'.$file_type.'/'.$merchandiser->id, $fileName);

        $merchandiser->update([$file_type => storage_path('app/public/'.$file_type.'/'.$merchandiser->id.'/'.$fileName)]);
    }


   /*  public function saveAvatar(Merchandiser $merchandiser, Request $request)
    {

        $this->storePhotos($merchandiser, 'avatar');

        return response()->json(['status' => 'saved avatar'], 200);

    } */


    public function saveAvatarAndCover(Merchandiser $merchandiser, Request $request)
    {
        $request->validate([
            'cover_photo' => 'nullable|image|mimes:png,jpg,jpeg',
            
            'avatar' => 'nullable|image|mimes:png,jpg,jpeg'

        ]);

        $this->storePhotos($merchandiser, 'cover_photo');

        $this->storePhotos($merchandiser, 'avatar');

        return response()->json(['status' => 'saved photos'], 200);

    }

    
    public function update(Merchandiser $merchandiser, UpdateMerchandiserRequest $request)
    {
        $merchandiser->update($request->validated());

        return response()->json(['status' => 'success'], 200);
    }   
}
