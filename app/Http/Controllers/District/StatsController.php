<?php

namespace App\Http\Controllers\District;

use App\Http\Controllers\Controller;
use App\Http\Resources\MonthsStatsResource;
use App\Http\Resources\WeeklyStatsResource;
use App\Http\Resources\YearlyStatsResource;
use App\Http\Services\Statics;
use App\Models\IssuedProduct;
use App\Models\Product;
use App\Models\Victim;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function getStats(Request $request): array
    {
        if($request->filled('start_date') && $request->filled('end_date'))
        {
            $start_date = Carbon::parse($request->start_date);

            $end_date = Carbon::parse($request->end_date);

            if ($end_date->diffInWeeks($start_date) === 4)
            {
                return $this->weeklyOrMonthly($start_date, $end_date);

            } elseif ($end_date->diffInWeeks($start_date) > 4 && $end_date->diffInYears($start_date) <= 1) {

                return $this->monthsStats($start_date, $end_date);

            } else {

                return $this->yearly($start_date, $end_date);
            }

        }else{

            $start_date = Carbon::now()->startOfMonth();

            $end_date = Carbon::now()->endOfMonth();
        }

        return $this->weeklyOrMonthly($start_date, $end_date);
    }

    public function weeklyOrMonthly($start_date, $end_date): array
    {
        $group_by_string = 'CAST(created_at AS DATE)';

        $victim_stats = $this->fetchVictimStats($start_date, $end_date, $group_by_string)
            ->districtVictims()
            ->groupBy(DB::raw($group_by_string))->get();

        $product_stats = $this->fetchDistrictProductStats($start_date, $end_date, $group_by_string)
            ->districtProducts()
            ->groupBy(DB::raw($group_by_string))->get();

        $reported_cases = $this->fetchReportedCases($start_date, $end_date, $group_by_string)
            ->districtQuery()
            ->groupBy(DB::raw($group_by_string))->get();

        return [
            'victims_stats' => WeeklyStatsResource::collection($victim_stats),
            'products_stats' => WeeklyStatsResource::collection($product_stats),
            'reported_cases' => WeeklyStatsResource::collection($reported_cases),
        ];
    }

    public function yearly($start_date, $end_date): array
    {
        $group_by_string = 'extract(year from created_at) as created_at';

        $victim_stats = $this->fetchVictimStats($start_date, $end_date, $group_by_string)
            ->districtVictims()
            ->groupBy(DB::raw('extract(year from created_at)'))->get();

        $product_stats = $this->fetchDistrictProductStats($start_date, $end_date, $group_by_string)
            ->districtProducts()
            ->groupBy(DB::raw('extract(year from created_at)'))->get();

        $reported_cases = $this->fetchReportedCases($start_date, $end_date, $group_by_string)
            ->districtQuery()
            ->groupBy(DB::raw('extract(year from created_at)'))->get();

        return [
            'victims_stats' => YearlyStatsResource::collection($victim_stats),
            'products_stats' => YearlyStatsResource::collection($product_stats),
            'reported_cases' => YearlyStatsResource::collection($reported_cases),
        ];
    }

    public function monthsStats($start_date, $end_date): array
    {
        $group_by_string = 'extract(month from created_at) as created_at';

        $victim_stats = $this->fetchVictimStats($start_date, $end_date, $group_by_string)
            ->districtVictims()
            ->groupBy(DB::raw('extract(month from created_at)'))->get();

        $product_stats = $this->fetchDistrictProductStats($start_date, $end_date, $group_by_string)
            ->districtProducts()
            ->groupBy(DB::raw('extract(month from created_at)'))->get();

        $reported_cases = $this->fetchReportedCases($start_date, $end_date, $group_by_string)
            ->districtQuery()
            ->groupBy(DB::raw('extract(month from created_at)'))->get();

        return [
            'victims_stats' => MonthsStatsResource::collection($victim_stats),
            'products_stats' => MonthsStatsResource::collection($product_stats),
            'reported_cases' => MonthsStatsResource::collection($reported_cases),
        ];
    }

//    public function fetchDistrictProductStats(Carbon $start_date, Carbon $end_date, $group_by_string): \Illuminate\Database\Eloquent\Builder
//    {
//        return Product::query()
//            ->join('facilities', 'facilities.id', '=', 'products.facility_id')
//            ->join('districts', 'districts.id', '=', 'facilities.district_id')
//            ->select(DB::raw("count(id), {$group_by_string}"))
//            ->where('districts.id',  '=', auth()->guard('district_admin')->user()->district_id)
//            ->whereBetween('created_at', [$start_date, $end_date]);
//    }
}
