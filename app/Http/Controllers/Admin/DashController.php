<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IssuedProduct;
use App\Models\Product;
use App\Models\Victim;
use Carbon\Carbon;

class DashController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function getStats()
    {
        $start_of_month = Carbon::parse(now());

        $end_of_month = Carbon::parse(now())->endOfMonth();

        $new_victims = Victim::query()->whereBetween('created_at', [$start_of_month, $end_of_month])->count();

        $new_products = Product::query()->whereBetween('created_at', [$start_of_month, $end_of_month])->count();

        $reported_issues = IssuedProduct::query()->whereBetween('created_at', [$start_of_month, $end_of_month])->count();

        return response()->json([
            'no_of_new_victims' => $new_victims,
            'no_of_new_products' => $new_products,
            'report_issues' => $reported_issues
        ]);
    }


}
