<?php

namespace App\Http\Controllers\Facilitator;

use App\Http\Controllers\Controller;
use App\Http\Requests\VictimRequest;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\SingleVictimResource;
use App\Http\Resources\VictimReportResource;
use App\Http\Resources\VictimResource;
use App\Models\Victim;
use Carbon\Carbon;

class VictimsController extends Controller
{

    public function __construct()
    {
        $this->middleware('api');
    }

    public function fetchVictims(): VictimResource
    {
        $victims = Victim::query()->paginate(20);

        return new VictimResource($victims);
    }


    public function createVictim(VictimRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        $data['facility_id'] = auth()->guard('')->user()->facility_id;

        $victim = Victim::create($data);

        return response()->json(['message' => 'victim created',

            'data' => [

                'id' => $victim->id,

                'name' => $victim->name,

                'age' => Carbon::parse($victim->dob)->age,

                'town' => $victim->town,

                'district' => new DistrictResource($victim->district),

                'gender' => $victim->gender
            ]
        ]);
    }

    public function fetchVictim(Victim $victim): SingleVictimResource
    {
        return new SingleVictimResource($victim);
    }

    public function updateVictim(Victim $victim, VictimRequest $request): \Illuminate\Http\JsonResponse
    {
        $victim->update($request->validated());

        return response()->json(['message' => 'victim updated']);
    }

    public function deleteVictim(Victim $victim): \Illuminate\Http\JsonResponse
    {
        $victim->delete();

        return response()->json(['message' => "{$victim->name} has been deleted"]);
    }


    public function fetchPreviousReports(Victim $victim): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return VictimReportResource::collection($victim->cases());
    }
}
