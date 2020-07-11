<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\EnquiryFormMailHandler;
use Illuminate\Support\Facades\Mail;

class EnquiryFormMailHandlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $formInputs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($formInputs)
    {
        $this->formInputs = $formInputs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(env('MAIL_FROM_ADDRESS'))
        
            ->queue(new EnquiryFormMailHandler($this->formInputs)
        );

    }
}