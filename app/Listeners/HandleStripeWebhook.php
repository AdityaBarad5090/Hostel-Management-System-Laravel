<?php

namespace App\Listeners;

use App\Models\Student;
use Laravel\Cashier\Events\WebhookHandled;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

class HandleStripeWebhook
{
    public function handle(WebhookHandled $event)
    {
        $payload = $event->payload;

        if ($payload['type'] === 'invoice.payment_succeeded') {
            $student = Student::where('stripe_id', $payload['data']['object']['customer'])->first();

            if ($student) {
                $stripeInvoiceId = $payload['data']['object']['id'];
                $invoice = $student->findInvoice($stripeInvoiceId);
                $hostedUrl = $invoice->hosted_invoice_url;

                \Illuminate\Support\Facades\Mail::to($student->email)
                    ->send(new \App\Mail\FeeReminderMail($student->fee));
            }
        }
        if ($payload['type'] === 'customer.subscription.deleted') {
            $student = Student::where('stripe_id', $payload['data']['object']['customer'])->first();

            if ($student) {
                $student->fees()->update(['status' => 'pending']);
                $student->save();
            }
        }
    }
}
