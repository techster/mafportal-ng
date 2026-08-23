<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ShopNotification extends Notification
{
    use Queueable;

    public $shop;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($shop)
    {
        $this->shop = $shop;
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
        $notifiable = $this->shop;
        return (new MailMessage)

            ->greeting('Hello '.$notifiable->name)
            ->subject('Thank you for shopping with us.')
            ->line("Order # $notifiable->order_id")
            ->line("List Of Products -- $notifiable->product")
            ->line("Order Total Amount: $$notifiable->order_price ")
            ->line("If your product requires shipping, we’ll send you an additional confirmation.")
            ->cc('drhagopjanian@yahoo.com', '');
    }

    public function cc($address, $name = null)
    {
        $this->cc = [$address, $name];
        return $this;
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
