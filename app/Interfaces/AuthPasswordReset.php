<?php

namespace App\Interfaces;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;

interface AuthPasswordReset
{
    public function changeUserPassword(ChangePasswordRequest $request): \Illuminate\Http\JsonResponse;

    public function sendResetMail(Request $request): \Illuminate\Http\JsonResponse;

    public function reset(Request $request): \Illuminate\Http\JsonResponse;

}