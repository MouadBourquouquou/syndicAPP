<?php

// app/Notifications/GeneralNotification.php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class GeneralNotification extends Notification
{
    protected $title;
    protected $message;
    protected $url;
    protected $priority;
    protected $category;
    protected $icon;
    protected $color;
    protected $badge;
    protected $badgeColor;

    public function __construct($title, $message, $url = null, $priority = 'normal', $category = 'general', $icon = 'fas fa-bell', $color = 'primary', $badge = null, $badgeColor = 'secondary')
    {
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
        $this->priority = $priority;
        $this->category = $category;
        $this->icon = $icon;
        $this->color = $color;
        $this->badge = $badge;
        $this->badgeColor = $badgeColor;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'url' => $this->url,
            'priority' => $this->priority,
            'category' => $this->category,
            'icon' => $this->icon,
            'color' => $this->color,
            'badge' => $this->badge,
            'badge_color' => $this->badgeColor,
        ];
    }
}

