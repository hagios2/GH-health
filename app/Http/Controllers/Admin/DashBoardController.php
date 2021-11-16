<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IssuedProduct;
use App\Models\Product;
use App\Models\Victim;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:admin');
    }

    public function getStats(Request $request): \Illuminate\Http\JsonResponse
    {
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = Carbon::parse($request->start_date)->startOfYear();

            $end_date = Carbon::parse($request->end_date)->endOfYear();
        } else {
            $start_date = Carbon::now()->subMonth()->startOfMonth();

            $end_date = Carbon::parse(now())->endOfMonth();
        }

        $victims_report = $this->fetchVictimStats($start_date, $end_date, $request)->groupBy('Year(created_at)')->get();

        $product_report = $this->fetchDistrictProductStats($start_date, $end_date, $request)
            ->groupBy('Year(created_at)')->get();

        $reported_cases = $this->fetchReportedCases($start_date, $end_date, $request)
            ->groupBy('Year(created_at)')->get();

        return response()->json([
            'victims_stats' => $victims_report,
            'products_stats' => $product_report,
            'reported_cases' => $reported_cases
        ]);
    }

    public function monthly(Request $request): void
    {
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = Carbon::parse($request->start_date)->startOfMonth();

            $end_date = Carbon::parse($request->end_date)->endOfMonth();
        } else {
            $start_date = Carbon::parse(now())->startOfMonth();

            $end_date = Carbon::parse(now())->startOfMonth();
        }

        $this->fetchVictimStats($start_date, $end_date, $request)->groupBy('Month(created_at)');

        $this->fetchDistrictProductStats($start_date, $end_date, $request)->groupBy('Month(created_at)');

        $this->fetchReportedCases($start_date, $end_date, $request)->groupBy('Month(created_at)');
    }

    public function weekly(Request $request): void
    {
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start_date = Carbon::parse($request->start_date)->startOfWeek();

            $end_date = Carbon::parse($request->end_date)->endOfWeek();
        } else {
            $start_date = Carbon::parse(now())->startOfWeek();

            $end_date = Carbon::parse(now())->endOfWeek();
        }

        $this->fetchVictimStats($start_date, $end_date, $request);

        $this->fetchDistrictProductStats($start_date, $end_date, $request);

        $this->fetchReportedCases($start_date, $end_date, $request);
    }

    public function fetchVictimStats(
        Carbon $start_date,
        Carbon $end_date,
        $group_by_string = null
    ): \Illuminate\Database\Eloquent\Builder {
        return Victim::query()
            ->select('count(id), created_at')
            ->whereBetween('created_at', [$start_date, $end_date]);
    }

    public function fetchDistrictProductStats(
        Carbon $start_date,
        Carbon $end_date,
        $group_by_string = null
    ): \Illuminate\Database\Eloquent\Builder {
        return Product::query()
            ->whereBetween('created_at', [$start_date, $end_date]);
    }

    public function fetchReportedCases(
        Carbon $start_date,
        Carbon $end_date,
        $group_by_string = null
    ): \Illuminate\Database\Eloquent\Builder {
        return IssuedProduct::query()
            ->whereBetween('created_at', [$start_date, $end_date]);
    }

    public function getStates(Request $request): \Illuminate\Http\JsonResponse
    {

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $new_victims = Victim::query()
                ->whereBetween('created_at', [$request->start_date, $request->end_date])->count();

            $new_products = Product::query()
                ->whereBetween('created_at', [$request->start_date, $request->end_date])->count();

            $reported_issues = IssuedProduct::query()
                ->whereBetween('created_at', [$request->start_date, $request->end_date])->count();
        } else {
            $start_of_month = Carbon::parse(now());

            $end_of_month = Carbon::parse(now())->endOfMonth();

            $new_victims = Victim::query()->whereBetween('created_at', [$start_of_month, $end_of_month])->count();

            $new_products = Product::query()->whereBetween('created_at', [$start_of_month, $end_of_month])->count();

            $reported_issues = IssuedProduct::query()
                ->whereBetween('created_at', [$start_of_month, $end_of_month])->count();
        }

        return response()->json([
            'no_of_new_victims' => $new_victims,
            'no_of_new_products' => $new_products,
            'report_issues' => $reported_issues
        ]);
    }
}
