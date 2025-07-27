<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notifiable;

class NotificationController extends Controller
{
    
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get all notifications with latest first
        $allNotifications = $user->notifications()->latest();
        
        // Apply filters based on request
        $notifications = $allNotifications;
        
        if ($request->filter === 'unread') {
            $notifications = $user->unreadNotifications()->latest();
        } elseif ($request->filter === 'important') {
            $notifications = $user->notifications()
                ->whereRaw("JSON_EXTRACT(data, '$.priority') = 'high'")
                ->latest();
        } elseif ($request->filter === 'system') {
            $notifications = $user->notifications()
                ->whereRaw("JSON_EXTRACT(data, '$.category') = 'system'")
                ->latest();
        }
        
        // Paginate results
        $notifications = $notifications->paginate(15);
        
        // Calculate counts for filter tabs
        $totalNotifications = $user->notifications()->count();
        $unreadNotifications = $user->unreadNotifications()->count();
        
        // Count important notifications (priority = 'high')
        $importantNotifications = $user->notifications()
            ->whereRaw("JSON_EXTRACT(data, '$.priority') = 'high'")
            ->count();
        
        // Count system notifications (category = 'system')
        $systemNotifications = $user->notifications()
            ->whereRaw("JSON_EXTRACT(data, '$.category') = 'system'")
            ->count();

        return view('notifications.index', compact(
            'notifications',
            'totalNotifications',
            'unreadNotifications',
            'importantNotifications',
            'systemNotifications'
        ));
    }

    public function markAsRead($id)
    {
        try {
            $user = Auth::user();
            $notification = $user->notifications()->findOrFail($id);
            
            // Log for debugging
            Log::info("Marking notification {$id} as read for user {$user->id}", [
                'notification_data' => $notification->data,
                'current_read_at' => $notification->read_at
            ]);
            
            // Mark the notification as read
            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Notification marquée comme lue',
                'notification_id' => $id,
                'read_at' => $notification->fresh()->read_at, // Get the updated read_at value
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning("Notification {$id} not found for user " . Auth::id());
            return response()->json([
                'success' => false,
                'message' => 'Notification introuvable'
            ], 404);
        } catch (\Exception $e) {
            Log::error("Error marking notification {$id} as read: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour'
            ], 500);
        }
    }

   public function getUnreadCount()
{
    try {
        return response()->json([
            'success' => true,
            'count' => auth()->user()->unreadNotifications()->count()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'count' => 0,
            'error' => $e->getMessage()
        ], 500);
    }
}

public function markAllAsReadMini()
{
    try {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}
    private function getNotificationUrl($notification)
    {
        $data = $notification->data;
        $modelKeyword = strtolower($data['model_keyword'] ?? '');
        $modelId = $data['model_id'] ?? null;
        
        Log::info('Getting notification URL', [
            'model_keyword' => $modelKeyword,
            'model_id' => $modelId,
            'notification_data' => $data
        ]);
        
        if (!$modelKeyword || !$modelId) {
            return route('dashboard');
        }
        
        // Map keywords to routes
        $routeMap = [
            'appartement' => 'appartements.show',
            'immeuble' => 'immeubles.show',
            'residence' => 'residences.show',
            'employe' => 'employes.show',
            'charge' => 'charges.show',
            'payé' => 'paiements.historique', // Add this line
        ];
        $AssistantRouteMap = [
            'appartement' => 'assistant.appartements.show',
            'immeuble' => 'assistant.immeubles.show',
            'residence' => 'assistant.residences.show',
            'employe' => 'assistant.employes.show',
            'charge' => 'assistant.charges.show',
            'payé' => 'assistant.paiements.historique', // Add this line
        ];

        if(auth()->user()->statut=="assistant_syndic") {
           try {
                if (isset($AssistantRouteMap[$modelKeyword])) {
                    $routeName = $AssistantRouteMap[$modelKeyword];
                    
                    // Check if route exists
                    if (\Route::has($routeName)) {
                        return route($routeName, $modelId);
                    } else {
                        // Try index route instead
                        $indexRoute = str_replace('.show', '.index', $routeName);
                        if (\Route::has($indexRoute)) {
                            return route($indexRoute);
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('Assistant route generation error: ' . $e->getMessage(), [
                    'model_keyword' => $modelKeyword,
                    'model_id' => $modelId,
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }
        else{

            try {
            if (isset($routeMap[$modelKeyword])) {
                $routeName = $routeMap[$modelKeyword];
                
                // Check if route exists
                if (\Route::has($routeName)) {
                    return route($routeName, $modelId);
                } else {
                    // Try index route instead
                    $indexRoute = str_replace('.show', '.index', $routeName);
                    if (\Route::has($indexRoute)) {
                        return route($indexRoute);
                    }
                }
            }
            
            return route('dashboard');
        } catch (\Exception $e) {
            Log::error('Route generation error: ' . $e->getMessage(), [
                'model_keyword' => $modelKeyword,
                'model_id' => $modelId,
                'trace' => $e->getTraceAsString()
            ]);
            return route('dashboard');
        }
    }
  }


    /**
     * Show a specific notification and mark it as read
     */
    public function show($id)
    {
        try {
            $user = Auth::user();
            $notification = $user->notifications()->findOrFail($id);
            
            // Mark as read if not already read
            if (!$notification->read_at) {
                $notification->markAsRead();
            }
            
            // Get the URL for the related model
            $modelUrl = $this->getNotificationUrl($notification);
            
            // Redirect to the model page instead of showing notification detail
            return redirect($modelUrl);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('notifications')->with('error', 'Notification introuvable');
        } catch (\Exception $e) {
            Log::error("Error showing notification {$id}: " . $e->getMessage());
            return redirect()->route('dashboard');
        }
    }

    /**
     * Toggle read status of a notification
     */
    public function toggleRead($id)
    {
        try {
            $user = Auth::user();
            $notification = $user->notifications()->findOrFail($id);
            
            if ($notification->read_at) {
                // Mark as unread
                $notification->update(['read_at' => null]);
                $message = 'Notification marquée comme non lue';
                $status = 'unread';
            } else {
                // Mark as read
                $notification->markAsRead();
                $message = 'Notification marquée comme lue';
                $status = 'read';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'notification_id' => $id,
                'status' => $status,
                'read_at' => $notification->read_at
            ]);
        } catch (\Exception $e) {
            Log::error("Error toggling notification {$id}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour'
            ], 500);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        try {
            $user = Auth::user();
            $user->unreadNotifications->markAsRead();
            
            return response()->json([
                'success' => true,
                'message' => 'Toutes les notifications ont été marquées comme lues'
            ]);
        } catch (\Exception $e) {
            Log::error("Error marking all notifications as read for user " . Auth::id() . ": " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour'
            ], 500);
        }
    }
}