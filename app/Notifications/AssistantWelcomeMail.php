<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssistantWelcomeMail extends Notification
{
    public function __construct(
        private string $plainPassword  
    ) {}
    public function via($notifiable): array
    {
        return ['mail'];  
    }

    // 2️⃣ Le contenu du mail
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Vos accès à la plateforme Syndic')
            ->greeting('Bonjour '.$notifiable->prenom.' !')
            ->line('Votre compte assistant a été créé.')
            ->line('Adresse e‑mail : '.$notifiable->email)
            ->line('Mot de passe temporaire : **'.$this->plainPassword.'**')
            ->action('Se connecter', url('/login'))
            ->line('Pensez à changer votre mot de passe après connexion.');
    }
}
