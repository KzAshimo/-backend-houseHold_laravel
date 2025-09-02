<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\User\RoleEnum;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

        /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => RoleEnum::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // リレーション:category
    public function categories()
    {
        return $this->hasMany(Category::class);
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

    // リレーション:log
    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    // リレーション:export
    public function exports()
    {
        return $this->hasMany(Export::class);
    }

    // リレーション:notification
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // リレーション:notification_view
    public function notification_views()
    {
        return $this->hasMany(NotificationView::class);
    }
}
