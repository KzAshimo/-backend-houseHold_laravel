<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'incomes';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'memo',
    ];

    // リレーション:user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // リレーション:category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
