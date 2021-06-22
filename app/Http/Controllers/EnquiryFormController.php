<?php

namespace App\Http\Controllers;

use App\Mail\EnquiryFormMailHandler;
use App\Http\Requests\EnquiryFormRequest;
use Illuminate\Support\Facades\Mail;

class EnquiryFormController extends Controller
{

    public function handler(EnquiryFormRequest $request)
    {

        $formInputs = $request->validated();

        Mail::to('support@martekgh.com')->queue(new EnquiryFormMailHandler($formInputs));

        return response()->json(['status' => 'mail sent']);

    }
}
