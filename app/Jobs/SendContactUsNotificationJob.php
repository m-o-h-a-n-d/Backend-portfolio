<?php

namespace App\Jobs;

use App\Models\ContactUs;
use App\Models\User;
use App\Notifications\ContactUsNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendContactUsNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var array<int>
     */
    public array $backoff = [10, 30, 60];

    /**
     * Create a new job instance.
     */
    public function __construct(public ContactUs $contactUs)
    {
        $this->onQueue('default');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $recipients = User::query()->get();

        if ($recipients->isNotEmpty()) {
            Notification::sendNow($recipients, new ContactUsNotification($this->contactUs));
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('SendContactUsNotificationJob failed: ' . $exception->getMessage(), [
            'contact_us_id' => $this->contactUs->id,
            'exception' => $exception,
        ]);
    }
}
