<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReceiptEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $receipt, $customer, $business;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($receipt, $customer, $business)
    {
        $this->receipt = $receipt[0];

        $this->customer = $customer;

        $this->business = $business;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM'), env('MAIL_NAME'))
            ->subject('Thanks for your registration!')
            ->view('mails.receipt')
            ->with([
                'receipt' => $this->receipt,
                'customer' => $this->customer,
                'business' => $this->business
            ]);
    }
}
