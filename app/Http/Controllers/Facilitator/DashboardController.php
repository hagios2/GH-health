<?php

namespace App\Http\Controllers\Facilitator;

use App\Http\Controllers\Controller;
use App\Http\Resources\WeeklyStatsResource;
use App\Models\IssuedProduct;
use App\Models\Product;
use App\Models\Victim;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:admin');
    }

    public function getStats(Request $request)
    {
        if($request->filled('start_date') && $request->filled('end_date'))
        {
            $start_date = Carbon::parse($request->start_date)->startOfYear();

            $end_date = Carbon::parse($request->end_date)->endOfYear();

//            if($end_date->diffInWeeks($start_date) === 1)
//            {
//
//            }
//            elseif ($end_date->diffInMonths($start_date) === 1)
//            {
//
//            }else{
//
//            }
        }
        else{

            $start_date = Carbon::now()->subMonth()->startOfMonth();

            $end_date = Carbon::parse(now())->endOfMonth();
        }

//        $victims_report = $this->fetchVictimStats($start_date, $end_date, $request)->groupBy('created_at')->get();
//
//        $product_report = $this->fetchDistrictProductStats($start_date, $end_date, $request)->groupBy('created_at')->get();
//
//        $reported_cases = $this->fetchReportedCases($start_date, $end_date, $request)->groupBy('created_at')->get();
//
//        return response()->json([
//            'victims_stats' => $victims_report,
//            'products_stats' => $product_report,
//            'reported_cases' => $reported_cases
//        ]);

        return $this->weekly($start_date, $end_date, $request);

    }

    public function monthly(Request $request): void
    {
        if($request->filled('start_date') && $request->filled('end_date'))
        {
            $start_date = Carbon::parse($request->start_date)->startOfMonth();

            $end_date = Carbon::parse($request->end_date)->endOfMonth();
        }
        else{

            $start_date = Carbon::parse(now())->startOfMonth();

            $end_date = Carbon::parse(now())->startOfMonth();
        }

        $this->fetchVictimStats($start_date, $end_date, $request)->groupBy('Month(created_at)');

        $this->fetchDistrictProductStats($start_date, $end_date, $request)->groupBy('Month(created_at)');

        $this->fetchReportedCases($start_date, $end_date, $request)->groupBy('Month(created_at)');
    }

    public function weekly($start_date, $end_date, $request): array
    {

        $victim_stats = $this->fetchVictimStats($start_date, $end_date, $request)->groupBy(DB::raw('CAST(created_at AS DATE)'))->get();

        $product_stats = $this->fetchDistrictProductStats($start_date, $end_date, $request)->groupBy('created_at')->get();

        $reported_cases = $this->fetchReportedCases($start_date, $end_date, $request)->groupBy('created_at')->get();

        return [
            'victims_stats' => WeeklyStatsResource::collection($victim_stats),
            'products_stats' => WeeklyStatsResource::collection($product_stats),
            'reported_cases' => WeeklyStatsResource::collection($reported_cases),
        ];
    }

    public function fetchVictimStats(Carbon $start_date, Carbon $end_date, Request $request): \Illuminate\Database\Eloquent\Builder
    {
        return Victim::query()
            ->select(DB::raw('count(id), created_at'))
            ->whereBetween('created_at', [$start_date, $end_date]);
    }

    public function fetchDistrictProductStats(Carbon $start_date, Carbon $end_date, Request $request): \Illuminate\Database\Eloquent\Builder
    {
        return Product::query()
            ->select(DB::raw('count(id), created_at'))
            ->whereBetween('created_at', [$start_date, $end_date]);
    }

    public function fetchReportedCases(Carbon $start_date, Carbon $end_date, Request $request): \Illuminate\Database\Eloquent\Builder
    {
        return IssuedProduct::query()
            ->select(DB::raw('count(id), created_at'))
            ->whereBetween('created_at', [$start_date, $end_date]);
    }

//    public function getStats(Request $request): \Illuminate\Http\JsonResponse
//    {
//
//        if($request->filled('start_date') && $request->filled('end_date'))
//        {
//            $new_victims = Victim::query()->whereBetween('created_at', [$request->start_date, $request->end_date])->count();
//
//            $new_products = Product::query()->whereBetween('created_at', [$request->start_date, $request->end_date])->count();
//
//            $reported_issues = IssuedProduct::query()->whereBetween('created_at', [$request->start_date, $request->end_date])->count();
//        }
//        else {
//
//            $start_of_month = Carbon::parse(now());
//
//            $end_of_month = Carbon::parse(now())->endOfMonth();
//
//            $new_victims = Victim::query()->whereBetween('created_at', [$start_of_month, $end_of_month])->count();
//
//            $new_products = Product::query()->whereBetween('created_at', [$start_of_month, $end_of_month])->count();
//
//            $reported_issues = IssuedProduct::query()->whereBetween('created_at', [$start_of_month, $end_of_month])->count();
//        }
//
//        return response()->json([
//            'no_of_new_victims' => $new_victims,
//            'no_of_new_products' => $new_products,
//            'report_issues' => $reported_issues
//        ]);
//    }

}
