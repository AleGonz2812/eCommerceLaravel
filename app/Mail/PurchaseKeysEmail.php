<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseKeysEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $purchaseData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($purchaseData)
    {
        $this->purchaseData = $purchaseData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('🎮 Tus Keys de PixelPlay - Pedido #' . $this->purchaseData['orderId'])
                    ->view('emails.purchase-keys');
    }
}
