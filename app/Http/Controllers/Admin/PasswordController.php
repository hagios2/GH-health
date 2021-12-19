<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthPasswordReset;
use App\Models\Admin;
use App\Models\ApiPasswordReset;
use App\Models\User;
use App\Services\AuthPasswordService;
use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;

class PasswordController extends Controller implements AuthPasswordReset
{
    private AuthPasswordService $authPasswordService;

    public function __construct(AuthPasswordService $authPasswordService)
    {
        $this->middleware('auth:api,admin', ['only' => ['changeUserPassword']]);

        $this->authPasswordService = $authPasswordService;
    }

    public function changeUserPassword(ChangePasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $client = auth()->guard('admin')->user();

        return $this->authPasswordService->changeToNewPassword($request, $client);
    }

    public function sendResetMail(Request $request): \Illuminate\Http\JsonResponse
    {

        $request->validate(['email' => 'required|email']);

        $client = Admin::query()->where('email', $request->email)->first();

        return $this->authPasswordService->sendPasswordResetMail($request, $client, 'isUserEmail');
    }

    public function reset(Request $request): \Illuminate\Http\JsonResponse
    {
        $token = ApiPasswordReset::where([['token', $request->token], ['isUserEmail', true]])->first();

        $client = Admin::query()->where('email', $token->email)->first();

        return $this->authPasswordService->reset($request, $token, $client);
    }

}
