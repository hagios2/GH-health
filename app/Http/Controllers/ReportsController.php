<?php

namespace App\Http\Controllers;

use App\Http\Requests\VictimRequest;
use App\Models\Victim;
use App\Http\Requests\ReportsRequest;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,admin');
    }

    public function reportVictim(VictimRequest $request): \Illuminate\Http\JsonResponse
    {
        $victim = Victim::create($request->validated());

        return response()->json(['message' => 'victim created']);

    }


    public function saveShopReport(ReportsRequest $request): \Illuminate\Http\JsonResponse
    {
        auth()->guard('api')->user()->addShopReport($request->validated());

        return response()->json(['status' => 'saved']);
    }


    public function saveProductReport(ReportsRequest $request): \Illuminate\Http\JsonResponse
    {
        auth()->guard('api')->user()->addProductReport($request->validated());

        return response()->json(['status' => 'saved']);
    }
}
