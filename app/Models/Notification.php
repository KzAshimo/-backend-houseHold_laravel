<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
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
        'content',
        'type',
        'start_date',
        'end_date',
    ];

        // リレーション:notification_view
    public function notification_views()
    {
        return $this->hasMany(NotificationView::class);
    }

}
