<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictRequest;
use App\Http\Requests\FacilityRequest;
use App\Http\Requests\RegionsRequest;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\FacilityResources;
use App\Http\Resources\RegionsResources;
use App\Models\District;
use App\Models\Facility;
use App\Models\Region;

class ResourcesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

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
        $region->delete();

        return response()->json(['message' => 'deleted']);
    }


    public function districtIndex()
    {
        return DistrictResource::collection(District::all());
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
        $district->delete();

        return response()->json(['message' => 'deleted']);
    }

    public function facilityIndex()
    {
        return new FacilityResources(Facility::query()->paginate(15));
    }

    public function storeFacility(FacilityRequest $request)
    {
        Facility::create($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function updateFacility(Facility $facility, FacilityRequest $request)
    {
        $facility->update($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function deleteFacility(Facility $facility)
    {
        $facility->delete();

        return response()->json(['message' => 'deleted']);
    }
}
