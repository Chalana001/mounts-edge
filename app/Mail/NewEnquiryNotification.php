<?php

namespace App\Mail;

use App\Models\Enquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Throwable;

class NewEnquiryNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Fail fast with no retries, matching the previous synchronous,
     * catch-and-mark-failed behavior.
     */
    public int $tries = 1;

    public function __construct(public Enquiry $enquiry)
    {
    }

    public function build(): self
    {
        return $this->replyTo($this->enquiry->email)
            ->subject("New {$this->enquiry->type} from {$this->enquiry->name}")
            ->text('emails.enquiry-notification');
    }

    /**
     * Called by Laravel's SendQueuedMailable job when sending ultimately
     * fails, whether that happens inline (sync queue connection) or later
     * in a queue worker (a real async connection).
     */
    public function failed(Throwable $exception): void
    {
        report($exception);
        $this->enquiry->update(['email_notification_failed' => true]);
    }
}
