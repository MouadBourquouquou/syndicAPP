<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserRejected extends Notification
{
    use Queueable;

    protected $reason;

    public function __construct($reason)
    {
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Demande rejetée')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre demande d’inscription a été rejetée par l’administrateur.')
            ->line('Raison : ' . $this->reason)
            ->line('Pour toute question, veuillez contacter l’administrateur.')
            ->action('Retour au site', url('/'))
            ->salutation('L’équipe Syndic App');
    }
}
