<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Fee;
use App\Jobs\SendFeeReminderJob;

class SendFeeReminders extends Command
{
    protected $signature = 'fees:reminder';

    protected $description = 'Send fee reminder emails to students';

    public function handle()
    {
        $fees = Fee::where('status', 'pending')->get();

        foreach ($fees as $fee) {

            SendFeeReminderJob::dispatch($fee);

        }

        $this->info('Fee reminder emails dispatched successfully.');
    }
}