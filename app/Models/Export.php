<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'exports';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'status',
        'period_from',
        'period_to',
        'file_name',
        'file_path',
    ];

    // リレーション:user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
