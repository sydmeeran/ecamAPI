<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContractEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM'), env('MAIL_NAME'))
            ->subject('contract contract!')
            ->view('mails.contract_email')
            ->with([
                'otp' => $this->data['otp'],
                'owner_name' => $this->data['owner_name'],
                'email' => $this->data['email'],
                'date' => date("Y/m/d"),
                'company_name' => $this->data['company_name'] 
            ]);
    }
}
