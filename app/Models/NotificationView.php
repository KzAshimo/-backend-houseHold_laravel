<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationView extends Model
{
    use SoftDeletes;
    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'notification_views';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'notification_id',
    ];

    // リレーション:user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // リレーション:notification
    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
