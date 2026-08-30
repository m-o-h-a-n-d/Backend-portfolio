<?php

namespace App\Notifications;

use App\Models\ContactUs;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactUsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public ContactUs $contactUs) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $setting = Setting::query()->first();
        $companyName = $setting?->company ?: config('app.name');
        $faviconUrl = $setting?->favicon ? asset($setting->favicon) : null;

        return (new MailMessage)
            ->subject('New Contact Us Message')
            ->view('emails.contact-us', [
                'contactUs' => $this->contactUs,
                'companyName' => $companyName,
                'faviconUrl' => $faviconUrl,
            ]);
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->contactUs->id,
            'name' => $this->contactUs->name,
            'email' => $this->contactUs->email,
            'subject' => $this->contactUs->subject,
            'message' => $this->contactUs->message,
            'read' => $this->contactUs->read,
            'created_at' => $this->contactUs->created_at?->toISOString(),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'id' => $this->contactUs->id,
            'name' => $this->contactUs->name,
            'email' => $this->contactUs->email,
            'subject' => $this->contactUs->subject,
            'message' => $this->contactUs->message,
            'read' => $this->contactUs->read,
            'created_at' => $this->contactUs->created_at?->toISOString(),
        ];
    }
}
