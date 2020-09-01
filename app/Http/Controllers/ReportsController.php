<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReportsRequest;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,admin');
    }


    public function saveShopReport(User $user, ReportsRequest $request)
    {
        $user->addReport($request->validated());

        return response()->json(['status' => 'saved']);
    }


    public function saveProductReport(User $user, ReportsRequest $request)
    {
        $user->addReport($request->validated());

        return response()->json(['status' => 'saved']);
    }
}
