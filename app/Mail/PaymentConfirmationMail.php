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
    public $confirmUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PaymentConfirmation $paymentConfirmation)
    {
        $this->paymentConfirmation = $paymentConfirmation;
        $this->confirmUrl = config('app.url') . '/payment/confirm/' . $paymentConfirmation->token;
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
