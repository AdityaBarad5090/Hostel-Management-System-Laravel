<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use SerializesModels;

    public $invoiceUrl;

    public function __construct($invoiceUrl)
    {
        $this->invoiceUrl = $invoiceUrl;
    }

    public function build()
    {
        return $this->subject('Hostel Fee Payment Invoice')
                    ->view('emails.invoice');
    }
}