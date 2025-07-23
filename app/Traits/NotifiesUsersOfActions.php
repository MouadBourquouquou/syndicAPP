<?php

namespace App\Traits;

use App\Notifications\ActionNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use App\Models\User;

trait NotifiesUsersOfActions
{
    public function notifyUser($action, $model, $modelName, $additionalData = [])
    {
        try {
            $users = User::where('id', '=', auth()->id())->get();
            
            Log::info('Notifying users', [
                'action' => $action,
                'model_id' => $model->id,
                'model_name' => $modelName,
                'users_count' => $users->count(),
                'current_user' => auth()->id()
            ]);

            if ($users->count() === 0) {
                Log::warning('No users found to notify');
                return;
            }

            foreach ($users as $user) {
                $user->notify(new ActionNotification(
                    $action,
                    $model,
                    $modelName,
                    auth()->user(),
                    $additionalData
                ));
                
                Log::info('Notification sent to user: ' . $user->id);
            }
        } catch (\Exception $e) {
            Log::error('Notification error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}