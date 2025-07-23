<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'type',
    ];

    // リレーション:user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // リレーション:income
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    // リレーション:expense
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
