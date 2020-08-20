<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Merchandiser;
use App\User;
use App\Http\Resources\AdminViewShopResource;
use App\Http\Resources\AdminViewUsersResource;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function getUsers()
    {
        return new AdminViewUsersResource(User::paginate(20));
    }


    public function getShops()
    {

        return new AdminViewShopResource(Merchandiser::paginate(20));

    }
}
