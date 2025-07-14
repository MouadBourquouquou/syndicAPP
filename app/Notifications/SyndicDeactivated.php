<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SyndicDeactivated extends Notification
{
    public function via($notifiable)
    {
        // Tu peux choisir ['database'] ou ['mail'] ou les deux
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Votre compte a été désactivé')
            ->line('Bonjour ' . $notifiable->name . ',')
            ->line('Nous vous informons que votre compte de syndic a été désactivé par l\'administrateur.')
            ->line('Si vous pensez qu\'il s\'agit d\'une erreur, veuillez nous contacter.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Votre compte a été désactivé par l\'administrateur.'
        ];
    }
}
