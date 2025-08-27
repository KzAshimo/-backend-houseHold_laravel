<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;
    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'user_id',
        'content',
        'type',
        'start_date',
        'end_date',
    ];

    // リレーション:user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // リレーション:notification_view
    public function notification_views()
    {
        return $this->hasMany(NotificationView::class);
    }
}
