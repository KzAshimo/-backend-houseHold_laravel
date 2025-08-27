<?php

namespace App\Services\Notification;

use App\Models\Notification;

class ForLoginService
{
    public function __invoke(int $userId)
    {
        return Notification::query()
        ->where(function ($q) use ($userId){
            $q->where('type', 'always')
            ->orWhere(function($sub) use ($userId){
                $sub->where('type', 'once')
                ->whereNotIn('id', function ($q2) use ($userId){
                    $q2->select('notification_id')
                    ->from('notification_views')
                    ->where('user_id', $userId);
                });
            });
        })
        ->orderBy('created_at')
        ->get();
    }
}