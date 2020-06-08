<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campus;
use App\Http\Resources\CampusResource;

class ResourceController extends Controller
{
    
    public function getCampus()
    {
        return CampusResource::collection(Campus::all('id', 'campus'));
    }
}
