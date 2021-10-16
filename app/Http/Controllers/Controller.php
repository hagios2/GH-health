<?php

namespace App\Http\Controllers;

use App\Models\IssuedProduct;
use App\Models\Product;
use App\Models\User;
use App\Models\Victim;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function storeAvatar(User $user)
    {
        $file = request()->file('avatar');

        $fileName = $file->getClientOriginalName();

        $file->storeAs('public/avatar/'.$user->id, $fileName);

        $user->update(['avatar' => storage_path('app/public/avatar/'.$user->id.'/'.$fileName)]);
    }

    public function fetchVictimStats(Carbon $start_date, Carbon $end_date, $group_by_string): \Illuminate\Database\Eloquent\Builder
    {
        return Victim::query()
            ->select(DB::raw("count(id), $group_by_string"))
            ->whereBetween('created_at', [$start_date, $end_date]);
    }

    public function fetchDistrictProductStats(Carbon $start_date, Carbon $end_date, $group_by_string): \Illuminate\Database\Eloquent\Builder
    {
        return Product::query()
            ->select(DB::raw("count(id), $group_by_string"))
            ->whereBetween('created_at', [$start_date, $end_date]);
    }

    public function fetchReportedCases(Carbon $start_date, Carbon $end_date, $group_by_string): \Illuminate\Database\Eloquent\Builder
    {
        return IssuedProduct::query()
            ->select(DB::raw("count(id), $group_by_string"))
            ->whereBetween('created_at', [$start_date, $end_date]);
    }
}
