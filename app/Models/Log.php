<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
        /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'logs';

        /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'action',
        'detail',
    ];

    // リレーション:user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
