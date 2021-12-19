<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminFacilitatorsResource;
use App\Models\Facility;
use App\Models\User;


class FacilitatorController extends Controller
{
    public function fetchFacilitiesFacilitator(Facility $facility): AdminFacilitatorsResource
    {
        return new AdminFacilitatorsResource(User::query()->where('facility_id', $facility->id)->get());
    }
}
