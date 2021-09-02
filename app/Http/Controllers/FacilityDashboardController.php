<?php

namespace App\Http\Controllers;

use App\Models\IssuedProduct;
use App\Models\Product;
use App\Models\Victim;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FacilityDashboardController extends Controller
{
    public function getStats(Request $request)
    {

        if($request->filled('start_date') && $request->filled('end_date'))
        {
            $new_victims = Victim::query()->whereBetween('created_at', [$request->start_date, $request->end_date])->count();

            $new_products = Product::query()
                ->where('facility_id', auth()->user()->facility_id)
                ->whereBetween('created_at', [$request->start_date, $request->end_date])->count();

            $reported_issues = IssuedProduct::query()
                ->where('facility_id', auth()->user()->facility_id)
                ->whereBetween('created_at', [$request->start_date, $request->end_date])->count();
        }
        else {

            $start_of_month = Carbon::parse(now());

            $end_of_month = Carbon::parse(now())->endOfMonth();

            $new_victims = Victim::query()->whereBetween('created_at', [$start_of_month, $end_of_month])->count();

            $new_products = Product::query()
                ->where('facility_id', auth()->user()->facility_id)
                ->whereBetween('created_at', [$start_of_month, $end_of_month])->count();

            $reported_issues = IssuedProduct::query()
                ->where('facility_id', auth()->user()->facility_id)
                ->whereBetween('created_at', [$start_of_month, $end_of_month])->count();
        }








    }
}
