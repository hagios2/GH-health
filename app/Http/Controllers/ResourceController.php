<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campus;
use App\ShopType;
use App\Http\Resources\CampusResource;

class ResourceController extends Controller
{
    
    public function getCampus()
    {
        return CampusResource::collection(Campus::all('id', 'campus'));
    }


    public function getShopTypes()
    {
        return CampusResource::collection(ShopType::all('id', 'shop_type'));
    }
}
