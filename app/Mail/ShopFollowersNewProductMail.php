<?php

namespace App\Mail;

use App\Merchandiser;
use App\Product;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShopFollowersNewProductMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $merchandiser;

    public $product;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Merchandiser $merchandiser, Product $product, User $user)
    {
        $this->merchandiser = $merchandiser;

        $this->product = $product;

        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.product_notification_alert')
            ->subject("{$this->merchandiser->company_name}'s shop New Product Alert" );
    }
}
