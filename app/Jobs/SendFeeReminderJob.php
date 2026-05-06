<?php

namespace App\Jobs;

use App\Mail\FeeReminderMail;
use App\Models\Fee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendFeeReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;  

    public $fee;

    public function __construct(Fee $fee)
    {
        $this->fee = $fee;
    }    

    public function handle()
    {
        Mail::to($this->fee->student->email)
            ->send(new FeeReminderMail($this->fee));
    }
}