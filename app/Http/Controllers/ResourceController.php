<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Product;
use App\Models\Victim;


class ResourceController extends Controller
{
    public function fetchDistricts()
    {
        return District::query()->get(['id', 'name']);
    }

    public function fetchVictims()
    {
        return Victim::query()->get(['id', 'name']);
    }

    public function fetchProducts()
    {
        return Product::query()->get(['id', 'name']);
    }
}
