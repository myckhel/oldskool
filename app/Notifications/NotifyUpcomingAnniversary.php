<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyUpcomingAnniversary extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public $users)
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
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->greeting("Hello, $notifiable->firstname $notifiable->lastname")
            ->subject('Todays Hope Anniversaries')
            ->line('Here is the list of Anniversaries for the dat');

        $td = Carbon::now()->format('d');
        $tm = Carbon::now()->format('m');

        $this->users->map(
            function ($user) use ($mail, $td, $tm) {
                $m = Carbon::parse($user->dob)->format('m');
                $d = Carbon::parse($user->dob)->format('d');

                $isBDay = $td == $d && $tm == $m;

                $annText = $isBDay ? 'Birthday' : 'Wedding Anniversary';

                $mail->line("Name: $user->firstname $user->lastname")
                    ->line("Phone: $user->phone Email: $user->email")
                    ->line("Anniversary Type: $annText");
            }
        );

        return $mail;
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
