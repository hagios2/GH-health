<?php

namespace App\Http\Controllers;

use App\Campus;
use App\Category;
use App\District;
use App\Helpers\CollectionHelper;
use App\Http\Requests\DistrictRequest;
use App\Http\Requests\RegionsRequest;
use App\Http\Resources\CategoryProductResource;
use App\Http\Resources\RegionsResources;
use App\Http\Resources\RelatedProductResource;
use App\Product;
use App\Region;
use App\ShopAd;
use App\ShopType;
use App\CarouselControl;
use Illuminate\Http\Request;
use App\Http\Resources\CampusResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ResourceController extends Controller
{

    public function regionIndex()
    {
        return RegionsResources::collection(Region::all());
    }


    public function storeRegion(RegionsRequest $request)
    {
        Region::create($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function updateRegion(Region $region, RegionsRequest $request)
    {
        $region->update($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function deleteRegion(Region $region)
    {
        return new RegionsResources($region);
    }


    public function districtIndex()
    {
        return RegionsResources::collection(District::all());
    }


    public function storeDistrict(DistrictRequest $request)
    {
        District::create($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function updateDistrict(District $district, DistrictRequest $request)
    {
        $district->update($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function deleteDistrict(District $district)
    {
        return new RegionsResources($district);
    }

}
