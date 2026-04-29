<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminNotificationController extends Controller
{
    public function index(): View
    {
        $notifications = Notification::latest()->paginate(20);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification): RedirectResponse
    {
        $notification->markAsRead();

        return redirect()->back()->with('status', 'Notification marked as read.');
    }

    public function markAllAsRead(): RedirectResponse
    {
        Notification::unread()->update(['read_at' => now()]);

        return redirect()->back()->with('status', 'All notifications marked as read.');
    }

    public function destroy(Notification $notification): RedirectResponse
    {
        $notification->delete();

        return redirect()->back()->with('status', 'Notification deleted.');
    }

    public function unreadCount(): int
    {
        return Notification::unread()->count();
    }
}
