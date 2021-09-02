<?php

namespace App\Http\Services;

use App\Models\IssuedProduct;
use App\Models\Product;
use App\Models\Victim;
use Carbon\Carbon;
use Illuminate\Http\Request;

interface Statics
{
    public function yearly(Request $request): void;

    public function monthly(Request $request): void;

    public function weekly(Request $request): void;

    public function fetchVictimStats(Carbon $start_date, Carbon $end_date, Request $request): Victim;

    public function fetchDistrictProductStats(Carbon $start_date, Carbon $end_date, Request $request): Product;

    public function fetchReportedCases(Carbon $start_date, Carbon $end_date, Request $request): IssuedProduct;
}
