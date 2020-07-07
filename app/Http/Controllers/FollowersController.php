<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Merchandiser;
use App\Http\Resources\FollowersResource;

class FollowersController extends Controller
{
    
    public function __construct()
    {

        $this->middleware('auth:api,merchandiser');

    }


    public function followShop(Merchandiser $merchandiser)
    {

        $merchandiser->addFollower(['user_id' => auth()->guard('api')->id()]);


        return response()->json(['status' => 'success']);

    }


    public function unFollowShop(Merchandiser $merchandiser)
    {

        auth()->guard('api')->user()->following->where('merchandiser_id', $merchandiser)->delete();


        return response()->json(['status' => 'deleted', 'shop_followers' => $merchandiser->followers->count()]);

    }


    public function fetchfollowingShops()
    {
        $following = auth()->guard('api')->user()->following;


       return FollowersResource::collection($following);

    }


}
