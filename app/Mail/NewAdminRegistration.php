<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class NewAdminRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Admin $admin, $password)
    {
        $this->admin = $admin;

        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): NewAdminRegistration
    {
        return $this->markdown('mail.NewAdminRegistration');
    }
}
