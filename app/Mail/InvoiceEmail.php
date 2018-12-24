<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice, $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice, $customer)
    {
        $this->invoice = $invoice[0];

        $this->customer = $customer;
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
            ->view('mails.invoice')
            ->with([
                'invoice' => $this->invoice,
                'customer' => $this->customer
            ]);
    }
}
