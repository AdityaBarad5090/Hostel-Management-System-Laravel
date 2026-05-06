<?php

namespace App\Mail;

use App\Models\Fee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeeReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fee;
              
    public function __construct(Fee $fee) 
    {
        $this->fee = $fee;
    }

    public function build()                                                                     
    {                                                                                                       
        return $this->subject('Fee Reminder') 
            ->html('<h2>Dear ' . $this->fee->student->name . '</h2>
                   <p>Your fee of ₹' . $this->fee->amount . ' is pending.</p>
                   <p>Please pay as soon as possible.</p>
                   <p>Regards,<br>Hostel Management</p>');
    }
}
