<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $expected;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($expected)
    {
         $this->expected = $expected;
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
        $expected = $this->expected;
        return (new MailMessage)
                    ->line("Order# $expected->id . Due date: $expected->next_test_date you have this service due date please confirm your booking for this service")
                    ->action('Booking detail', url('/expected/add/'.$expected->id))
                    ->line('Thank you for using our application!');
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
