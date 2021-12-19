<?php

namespace App\Http\Controllers\District;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Interfaces\AuthPasswordReset;
use App\Models\ApiPasswordReset;
use App\Models\DistrictAdmin;
use App\Services\AuthPasswordService;
use Illuminate\Http\Request;

class PasswordResetController extends Controller implements AuthPasswordReset
{
    private AuthPasswordService $authPasswordService;

    public function __construct(AuthPasswordService $authPasswordService)
    {
        $this->middleware('auth:api,district', ['only' => ['changeUserPassword']]);

        $this->authPasswordService = $authPasswordService;
    }

    public function changeUserPassword(ChangePasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $client = auth()->guard('district_admin')->user();

        return $this->authPasswordService->changeToNewPassword($request, $client);
    }

    public function sendResetMail(Request $request): \Illuminate\Http\JsonResponse
    {

        $request->validate(['email' => 'required|email']);

        $client = DistrictAdmin::query()->where('email', $request->email)->first();

        return $this->authPasswordService->sendPasswordResetMail($request, $client, 'isDistrictEmail');
    }

    public function reset(Request $request): \Illuminate\Http\JsonResponse
    {
        $token = ApiPasswordReset::where([['token', $request->token], ['isUserEmail', true]])->first();

        $client = DistrictAdmin::query()->where('email', $token->email)->first();

        return $this->authPasswordService->reset($request, $token, $client);
    }
}
