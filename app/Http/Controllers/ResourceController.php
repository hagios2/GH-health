<?php

namespace App\Http\Controllers;

use App\Models\District;


class ResourceController extends Controller
{
    public function fetchDistricts()
    {
        return District::query()->get(['id', 'name']);
    }
}
