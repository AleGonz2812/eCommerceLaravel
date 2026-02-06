<?php

namespace App\Mail;

use App\Models\DiscountCode;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeLoginMail extends Mailable
{
    use Queueable, SerializesModels;

    public $discountCode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(DiscountCode $discountCode)
    {
        $this->discountCode = $discountCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('¡Bienvenido! Aquí está tu código de descuento')
                    ->view('emails.welcome-login');
    }
}
