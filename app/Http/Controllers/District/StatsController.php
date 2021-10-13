<?php

namespace App\Http\Controllers\District;

use App\Http\Controllers\Controller;
use App\Http\Services\Statics;
use App\Models\IssuedProduct;
use App\Models\Product;
use App\Models\Victim;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller implements Statics
{
    public function yearly(Request $request): void
    {
        if($request->filled('start_date') && $request->filled('end_date'))
        {
            $start_date = Carbon::parse($request->start_date)->startOfYear();

            $end_date = Carbon::parse($request->end_date)->endOfYear();
        }
        else{

            $start_date = Carbon::parse(now())->startOfYear();

            $end_date = Carbon::parse(now())->endOfYear();
        }

        $this->fetchVictimStats($start_date, $end_date, $request)->groupBy('Year(created_at)');

        $this->fetchDistrictProductStats($start_date, $end_date, $request)->groupBy('Year(created_at)');

        $this->fetchReportedCases($start_date, $end_date, $request)->groupBy('Year(created_at)');

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

    public function weekly(Request $request): void
    {
        if($request->filled('start_date') && $request->filled('end_date'))
        {
            $start_date = Carbon::parse($request->start_date)->startOfWeek();

            $end_date = Carbon::parse($request->end_date)->endOfWeek();
        }
        else{

            $start_date = Carbon::parse(now())->startOfWeek();

            $end_date = Carbon::parse(now())->endOfWeek();
        }

        $this->fetchVictimStats($start_date, $end_date, $request);

        $this->fetchDistrictProductStats($start_date, $end_date, $request);

        $this->fetchReportedCases($start_date, $end_date, $request);
    }

    public function fetchVictimStats(Carbon $start_date, Carbon $end_date, Request $request): Victim
    {
        return DB::table('victims')
            ->select('count(id), created_at')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->districtVictims();
    }

    public function fetchDistrictProductStats(Carbon $start_date, Carbon $end_date, Request $request): Product
    {
        return Product::query()
            ->whereBetween('created_at', [$start_date, $end_date])
            ->districtProducts();
    }

    public function fetchReportedCases(Carbon $start_date, Carbon $end_date, Request $request): IssuedProduct
    {
        return IssuedProduct::query()
            ->whereBetween('created_at', [$start_date, $end_date])
            ->districtQuery();
    }
}
