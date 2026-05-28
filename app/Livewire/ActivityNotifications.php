<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ActivityLog;

class ActivityNotifications extends Component
{
    public function getLogs()
    {
        return ActivityLog::with('user')->latest()->take(10)->get();
    }

    public function getUnreadCount()
    {
        return ActivityLog::where('is_read', false)->count();
    }

    public function markAllAsRead()
    {
        ActivityLog::where('is_read', false)->update(['is_read' => true]);
    }

    public function markAsRead($id)
    {
        ActivityLog::where('id', $id)->update(['is_read' => true]);
    }

    public function render()
    {
        return view('livewire.activity-notifications', [
            'logs' => $this->getLogs(),
            'unreadCount' => $this->getUnreadCount(),
        ]);
    }
}
