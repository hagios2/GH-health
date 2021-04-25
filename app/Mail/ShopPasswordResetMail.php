<?php

namespace App\Mail;

use App\ApiPasswordReset;
use App\Merchandiser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ShopPasswordResetMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $shop;

    public $token;
    /**
     * Create a new message.
     *
     * @return void
     */
    public function construct(Merchandiser $merchandiser, ApiPasswordReset $token)
    {
        $this->shop = $shop ?? Merchandiser::query()->where('email', $token->email)->first();

        $this->token = $token;
    }

    /**
     * Build the message.
     *
     *
     */
    public function build()
    {

        Log::info($this->shop);

        return $this->view('mail.ShopPasswordResetMail')
            ->subject('Password Reset');
    }
}
