<?php

namespace App\Notifications;

use App\Mail\HappyBirthday;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyAnniversary extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public $type = 'bday')
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(User $notifiable)
    {
        return $this->type == 'bday'
            ? (new MailMessage())
            ->subject("Happy Birthday to you {$notifiable->firstname} {$notifiable->lastname}")
            ->greeting("Hello $notifiable->firstname $notifiable->lastname")
            ->line('Many more years in good health')
            : (new MailMessage)
            ->subject("Happy Wedding Anniversary")
            ->greeting("Hello $notifiable->firstname $notifiable->lastname")
            ->line('Many more years together with your hobby in good health');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
