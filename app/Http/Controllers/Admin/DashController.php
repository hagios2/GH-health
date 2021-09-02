<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IssuedProduct;
use App\Models\Product;
use App\Models\Victim;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function getStats(Request $request): \Illuminate\Http\JsonResponse
    {

        if($request->filled('start_date') && $request->filled('end_date'))
        {
            $new_victims = Victim::query()->whereBetween('created_at', [$request->start_date, $request->end_date])->count();

            $new_products = Product::query()->whereBetween('created_at', [$request->start_date, $request->end_date])->count();

            $reported_issues = IssuedProduct::query()->whereBetween('created_at', [$request->start_date, $request->end_date])->count();
        }
        else {

            $start_of_month = Carbon::parse(now());

            $end_of_month = Carbon::parse(now())->endOfMonth();

            $new_victims = Victim::query()->whereBetween('created_at', [$start_of_month, $end_of_month])->count();

            $new_products = Product::query()->whereBetween('created_at', [$start_of_month, $end_of_month])->count();

            $reported_issues = IssuedProduct::query()->whereBetween('created_at', [$start_of_month, $end_of_month])->count();
        }

        return response()->json([
            'no_of_new_victims' => $new_victims,
            'no_of_new_products' => $new_products,
            'report_issues' => $reported_issues
        ]);
    }


}
