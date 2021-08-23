<?php

namespace App\Http\Controllers;

use App\Http\Requests\VictimRequest;
use App\Http\Resources\VictimResource;
use App\Models\Victim;
use Illuminate\Http\Request;

class VictimsController extends Controller
{
    public function fetchVictims()
    {
        $victims = Victim::query()->paginate(20);

        return new VictimResource($victims);
    }


    public function createVictim(VictimRequest $request)
    {
        $victim = Victim::create($request->validated());

        return response()->json(['message' => 'victim created'], 201);
    }

}
