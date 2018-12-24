<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuotationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $quotation, $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($quotation, $customer)
    {
        $this->quotation = $quotation;
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
            ->view('mails.quotation')
            ->with([
//                'otp' => $this->data['otp'],
//                'owner_name' => $this->data['owner_name'],
//                'email' => $this->data['email']
            ]);
    }
}
