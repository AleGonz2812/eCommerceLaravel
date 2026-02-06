<?php

namespace App\Mail;

use App\Models\PaymentConfirmation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $paymentConfirmation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PaymentConfirmation $paymentConfirmation)
    {
        $this->paymentConfirmation = $paymentConfirmation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirma tu compra de €' . number_format($this->paymentConfirmation->amount, 2))
                    ->view('emails.payment-confirmation');
    }
}
