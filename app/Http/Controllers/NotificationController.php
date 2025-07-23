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
        Log::info("Marking notification {$id} as read for user {$user->id}");
        
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
        Log::error("Error marking notification {$id} as read: " . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la mise à jour'
        ], 500);
    }
}
    public function getUnreadCount()
    {
        try {
            $count = Auth::user()->unreadNotifications()->count();
            
            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error("Error getting unread count for user " . Auth::id() . ": " . $e->getMessage());
            return response()->json([
                'success' => false,
                'count' => 0,
                'message' => 'Erreur lors de la récupération du nombre'
            ], 500);
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

            return view('notifications.show', compact('notification'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('notifications')->with('error', 'Notification introuvable');
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
}