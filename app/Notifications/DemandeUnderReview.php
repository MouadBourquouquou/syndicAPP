<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DemandeUnderReview extends Notification
{
    public function via($notifiable)
    {
        return ['mail']; // Notification via email
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Votre demande est en cours de validation')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Merci de vous être inscrit sur notre plateforme.')
            ->line('Votre demande est actuellement en cours de révision par notre équipe.')
            ->line('Vous recevrez un email une fois que votre compte sera activé.')
            ->salutation('Cordialement,')
            ->salutation('L’équipe Syndic App');
    }
}
