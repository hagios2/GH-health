<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictRequest;
use App\Http\Requests\FacilityRequest;
use App\Http\Requests\RegionsRequest;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\FacilityResources;
use App\Http\Resources\RegionsResources;
use App\Http\Resources\SingleFacilityResource;
use App\Models\District;
use App\Models\Facility;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ResourcesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function regionsIndex(): AnonymousResourceCollection
    {
        return RegionsResources::collection(Region::all());
    }

    public function storeRegion(RegionsRequest $request): JsonResponse
    {
        Region::create($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function updateRegion(Region $region, RegionsRequest $request): JsonResponse
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
    public function deleteRegion(Region $region): JsonResponse
    {
        $region->delete();

        return response()->json(['message' => 'deleted']);
    }


    public function districtIndex(): AnonymousResourceCollection
    {
        return DistrictResource::collection(District::all());
    }


    public function storeDistrict(DistrictRequest $request): JsonResponse
    {
        District::create($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function showDistrict(District $district): DistrictResource
    {
        return new DistrictResource($district);
    }

    public function updateDistrict(District $district, DistrictRequest $request): JsonResponse
    {
        $district->update($request->validated());

        return response()->json(['message' => 'success']);
    }

    /**
     * @throws \Exception
     */
    public function deleteDistrict(District $district): JsonResponse
    {
        $district->delete();

        return response()->json(['message' => 'deleted']);
    }

    public function facilityIndex(): FacilityResources
    {
        return new FacilityResources(Facility::query()->paginate(15));
    }

    public function storeFacility(FacilityRequest $request): JsonResponse
    {
        Facility::create($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function showFacility(Facility $facility): SingleFacilityResource
    {
        return new SingleFacilityResource($facility);
    }

    public function updateFacility(Facility $facility, FacilityRequest $request): JsonResponse
    {
        $facility->update($request->validated());

        return response()->json(['message' => 'success']);
    }

    public function deleteFacility(Facility $facility): JsonResponse
    {
        $facility->delete();

        return response()->json(['message' => 'deleted']);
    }
}
