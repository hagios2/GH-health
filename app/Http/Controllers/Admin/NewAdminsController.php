<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainAdminResource;
use App\Models\Admin;
use App\Jobs\NewAdminJob;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\NewAdminRequest;
use Illuminate\Support\Str;

class NewAdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('isSuperAdmin');
    }

    public function fetchAdmins(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return MainAdminResource::collection(Admin::query()->where('role', '!=', 'super_admin')->get());
    }

    public function newAdmin(NewAdminRequest $request): \Illuminate\Http\JsonResponse
    {
        if (auth()->guard('admin')->user()->role == 'super_admin') {
            $attributes = $request->validated();

            $password = Str::random(8);

            $attributes['password'] = Hash::make($password);

            $attributes['must_change_password'] = true;

            $admin = Admin::create($attributes);

            NewAdminJob::dispatch($admin, $password);

            return response()->json(['status' => 'new admin added']);
        }

        return response()->json(['message' => 'Forbidden'], 403);
    }

    public function blockAdmin(Admin $admin): \Illuminate\Http\JsonResponse
    {
        if ($admin->isActive) {
            $admin->update(['isActive' => false]);

            return response()->json(['message' => 'blocked']);
        }

        return response()->json(['message' => 'admin already blocked']);

    }


    public function unBlockAdmin(Admin $admin): \Illuminate\Http\JsonResponse
    {

        $admin->update(['isActive' => true]);

        return response()->json(['message' => 'unblocked']);
    }


    public function viewPersonnels()
    {
        $personnels = Admin::where('role', '!=', 'super_admin')->paginate(5);

        return view('view_personnels', compact('personnels'));
    }
}
