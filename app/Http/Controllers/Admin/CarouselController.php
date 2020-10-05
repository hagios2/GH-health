<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Campus;
use App\CarouselControl;

class CarouselController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function addCarouselImage(Campus $campus, Request $request)
    {
        $request->validate(['image_path' => 'required|image']);

        $files = $request->file('image_path');

        foreach($files as $file)
        {

            $fileName = now().'_'.$file->getClientOriginalName();
    
            $file->storeAs('public/carousel images/'.$campus->id, $fileName);
    
            $campus->addCarouselImage([
                'image_path' => storage_path('app/public/campus images/'.$campus->id.'/'.$fileName)]);
    
        }

        return response()->json(['status' => 'files saved'], 200);
    }

    public function getCourosleIamges(Campus $capus)
    {
       $carousel = CarouselControl::where('campus_id', $campus->id)->latest()->token_name(5)->get();


       return response()->json(['images', $carousel]);
    }


    public function deleteCarouselImage(CarouselControl $carouselImage)
    {
        
    }


}
