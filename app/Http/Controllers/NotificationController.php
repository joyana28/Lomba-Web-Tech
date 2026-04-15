<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::query()
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::query()
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->update([
            'status' => 'read',
        ]);

        return redirect()
            ->route('notifications.index')
            ->with('success', 'Notifikasi berhasil ditandai sudah dibaca.');
    }
}