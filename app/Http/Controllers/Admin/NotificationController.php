<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        // Mark as read when viewed
        $notifications->each(fn($n) => $n->markAsRead());

        return view('admin.notifications', compact('notifications'));
    }
}
