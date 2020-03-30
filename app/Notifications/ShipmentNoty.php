<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Shipment;

class ShipmentNoty extends Notification
{
    use Queueable;


    // public  = "shipment";
    public $shipment, $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Shipment $shipment, $type)
    {
        $this->type = $type;
        $this->shipment = $shipment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['broadcast'];
        return ['database', ];
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
            'shipment' => $this->shipment,
        ];
    }
}
