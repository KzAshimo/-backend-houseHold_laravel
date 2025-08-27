<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

        /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'expenses';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'content',
        'memo',
        'date',
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
