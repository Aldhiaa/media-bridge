<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    public function markRead(Request $request, string $notification): RedirectResponse
    {
        /** @var DatabaseNotification|null $record */
        $record = $request->user()->notifications()->find($notification);

        if ($record) {
            $record->markAsRead();
        }

        return back();
    }

    public function markAllRead(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'تم تعليم كل الإشعارات كمقروءة.');
    }
}
