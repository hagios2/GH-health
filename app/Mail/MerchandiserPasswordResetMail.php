<?php

namespace App\Mail;

use App\ApiPasswordReset;
use App\Merchandiser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MerchandiserPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $merchandiser;

    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Merchandiser $merchandiser, ApiPasswordReset $token)
    {
        $this->merchandiser = $merchandiser;

        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info($this->merchandiser);

        Log::info($this->token);


        return $this->view('mail.ShopPasswordResetMail')
            ->subject('Password Reset');
    }
}
