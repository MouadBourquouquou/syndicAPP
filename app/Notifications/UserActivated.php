<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserActivated extends Notification
{
    use Queueable;

    public function __construct(private $email, private $password)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Compte activé')
            ->greeting('Bonjour ' . $notifiable->prenom . ' ' . $notifiable->name . ',')
            ->line('Votre compte a été activé par l’administrateur.')
            ->line('Voici vos identifiants de connexion :')
            ->line('📧 Email : ' . $this->email)
            ->line('Vous pouvez maintenant vous connecter à votre compte.')
            ->line('Merci pour votre patience.')
            ->action('Se connecter', url('/login'))
            ->salutation('L’équipe Syndic App');
    }
}
