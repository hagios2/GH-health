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
//    public function __construct()
//    {
//        $this->middleware('auth:admin');
//    }

    public function regionsIndex(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return RegionsResources::collection(Region::all());
    }

    public function storeRegion(RegionsRequest $request): \Illuminate\Http\JsonResponse
    {
        Region::create($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function updateRegion(Region $region, RegionsRequest $request): \Illuminate\Http\JsonResponse
    {
        $region->update($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function showRegion(Region $region): RegionsResources
    {
        return new RegionsResources($region);
    }

    /**
     * @throws \Exception
     */
    public function deleteRegion(Region $region): \Illuminate\Http\JsonResponse
    {
        $region->delete();

        return response()->json(['message' => 'deleted']);
    }


    public function districtIndex(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return DistrictResource::collection(District::all());
    }


    public function storeDistrict(DistrictRequest $request): \Illuminate\Http\JsonResponse
    {
        District::create($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function updateDistrict(District $district, DistrictRequest $request): \Illuminate\Http\JsonResponse
    {
        $district->update($request->validated());

        return response()->json(['message' => 'success']);
    }

    /**
     * @throws \Exception
     */
    public function deleteDistrict(District $district): \Illuminate\Http\JsonResponse
    {
        $district->delete();

        return response()->json(['message' => 'deleted']);
    }

    public function facilityIndex(): FacilityResources
    {
        return new FacilityResources(Facility::query()->paginate(15));
    }

    public function storeFacility(FacilityRequest $request): \Illuminate\Http\JsonResponse
    {
        Facility::create($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function updateFacility(Facility $facility, FacilityRequest $request): \Illuminate\Http\JsonResponse
    {
        $facility->update($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function deleteFacility(Facility $facility): \Illuminate\Http\JsonResponse
    {
        $facility->delete();

        return response()->json(['message' => 'deleted']);
    }
}
