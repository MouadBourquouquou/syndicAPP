<?php
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                $view->with([
                    'unreadNotificationsCount' => $user->unreadNotifications()->count(),
                    'notifications' => $user->notifications()->latest()->take(10)->get() // or ->paginate()
                ]);
            }
        });
    }
}
