<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class SendRealTimeNotificationJob implements ShouldQueue
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
     *
     * @param mixed $recipients Single notifiable or collection/array of notifiables
     * @param Notification $notification The notification instance to send
     */
    public function __construct(
        public mixed $recipients,
        public Notification $notification
    ) {
        $this->onQueue('default');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (empty($this->recipients)) {
            return;
        }

        NotificationFacade::send($this->recipients, $this->notification);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('SendRealTimeNotificationJob failed: ' . $exception->getMessage(), [
            'exception' => $exception,
        ]);
    }
}
