<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EnquiryFormRequest;
use App\Jobs\EnquiryFormMailHandlerJob;

class EnquiryFormController extends Controller
{
    
    public function handler(EnquiryFormRequest $request)
    {

        $formInputs = $request->validate();


        EnquiryFormMailHandlerJob::dispatch($formInputs);

    }
}
