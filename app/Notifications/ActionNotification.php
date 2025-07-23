<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActionNotification extends Notification
{
    use Queueable;

    protected $action;
    protected $model;
    protected $modelName;
    protected $user;
    protected $additionalData;

    public function __construct($action, $model, $modelName, $user, $additionalData = [])
    {
        $this->action = $action;
        $this->model = $model;
        $this->modelName = $modelName;
        $this->user = $user;
        $this->additionalData = $additionalData;
    }

    public function via($notifiable)
    {
        return ['database']; // or ['mail', 'database'] depending on your needs
    }

    public function toArray($notifiable)
    {
        return [
            'action' => $this->action,
            'model_id' => $this->model->id,
            'model_name' => $this->modelName,
            'user_name' => $this->user->name,
            'message' => $this->user->name  . $this->action  . strtolower($this->modelName),
            'priority' => 'medium', // Add riority for your filtering
            'category' => 'system', // Add category for your filtering
            'additional_data' => $this->additionalData,
        ];
    }
}