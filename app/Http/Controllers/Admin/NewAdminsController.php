<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\NewAdminJob;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\NewAdminRequest;
use App\Admin;
use Illuminate\Support\Str;

class NewAdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('isSuperAdmin')->except('changePassword');
    }



    public function newAdmin(NewAdminRequest $request)
    {

        if(auth()->guard('admin')->user()->role == 'super_admin')
        {
        
            $attibutes = $request->validated();

            $password = Str::random(8);

            $attibutes['password'] = Hash::make($password);

            $attributes['must_change_password'] = true;

            $admin = Admin::create($attibutes);

            NewAdminJob::dispatch($admin, $password);

            return response()->json(['status' => 'new admin added']);
        }   

        return response()->json(['message' => 'Forbidden'], 403);

    }


    public function changePassword(Request $request)
    {
        
        $password = $request->validate([

            'password' => 'required|string'
        
        ]);
        
        auth()->guard('admin')->user()->update([

            'password' => Hash::make($password['password'])
        
        ]);

        return response()->json(['status' => 'password changed']);
    }


    public function blockAdmin(Admin $admin)
    {

        $admin->update(['isActive' => false]);

       
        return response()->json(['message' => 'blocked']);
    }


    public function unBlockAdmin(Admin $admin)
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
