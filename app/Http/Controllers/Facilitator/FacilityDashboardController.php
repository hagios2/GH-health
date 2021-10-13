<?php

namespace App\Http\Controllers\Facilitator;

use App\Http\Controllers\Controller;
use App\Models\IssuedProduct;
use App\Models\Product;
use App\Models\Victim;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FacilityDashboardController extends Controller
{

    public function getStats(Request $request): \Illuminate\Http\JsonResponse
    {
        if($request->filled('start_date') && $request->filled('end_date'))
        {
            $start_date = Carbon::parse($request->start_date)->startOfYear();

            $end_date = Carbon::parse($request->end_date)->endOfYear();
        }
        else{

            $start_date = Carbon::now()->subMonth()->startOfMonth();

            $end_date = Carbon::parse(now())->endOfMonth();
        }

        $victims_report = $this->fetchVictimStats($start_date, $end_date, $request)->groupBy('Year(created_at)')->get();

        $product_report = $this->fetchDistrictProductStats($start_date, $end_date, $request)->groupBy('Year(created_at)')->get();

        $reported_cases = $this->fetchReportedCases($start_date, $end_date, $request)->groupBy('Year(created_at)')->get();

        return response()->json([
            'victims_stats' => $victims_report,
            'products_stats' => $product_report,
            'reported_cases' => $reported_cases
        ]);
    }


    public function fetchVictimStats(Carbon $start_date, Carbon $end_date, Request $request): \Illuminate\Database\Eloquent\Builder
    {
        return Victim::query()
            ->where('facility_id', auth()->user()->facility_id)
            ->select('count(id), created_at')
            ->whereBetween('created_at', [$start_date, $end_date]);
    }

    public function fetchDistrictProductStats(Carbon $start_date, Carbon $end_date, Request $request): \Illuminate\Database\Eloquent\Builder
    {
        return Product::query()
            ->where('facility_id', auth()->user()->facility_id)
            ->whereBetween('created_at', [$start_date, $end_date]);
    }

    public function fetchReportedCases(Carbon $start_date, Carbon $end_date, Request $request): \Illuminate\Database\Eloquent\Builder
    {
        return IssuedProduct::query()
            ->where('facility_id', auth()->user()->facility_id)
            ->whereBetween('created_at', [$start_date, $end_date]);
    }


//        if($request->filled('start_date') && $request->filled('end_date'))
//        {
//            $new_victims = Victim::query()->whereBetween('created_at', [$request->start_date, $request->end_date])->count();
//
//            $new_products = Product::query()
//                ->where('facility_id', auth()->user()->facility_id)
//                ->whereBetween('created_at', [$request->start_date, $request->end_date])->count();
//
//            $reported_issues = IssuedProduct::query()
//                ->where('facility_id', auth()->user()->facility_id)
//                ->whereBetween('created_at', [$request->start_date, $request->end_date])->count();
//        }
//        else {
//
//            $start_of_month = Carbon::parse(now());
//
//            $end_of_month = Carbon::parse(now())->endOfMonth();
//
//            $new_victims = Victim::query()->whereBetween('created_at', [$start_of_month, $end_of_month])->count();
//
//            $new_products = Product::query()
//                ->where('facility_id', auth()->user()->facility_id)
//                ->whereBetween('created_at', [$start_of_month, $end_of_month])->count();
//
//            $reported_issues = IssuedProduct::query()
//                ->where('facility_id', auth()->user()->facility_id)
//                ->whereBetween('created_at', [$start_of_month, $end_of_month])->count();
//        }
}
