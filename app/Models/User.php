<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'bio',
        'rating',
        'total_ratings',
        'is_admin',
    ];

    protected $appends = ['initial'];

    public function getInitialAttribute(): string
    {
        return strtoupper(substr($this->name ?? '?', 0, 1));
    }

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function foodPosts(): HasMany
    {
        return $this->hasMany(FoodPost::class);
    }

    public function skillPosts(): HasMany
    {
        return $this->hasMany(SkillPost::class);
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }

    public function givenRatings(): HasMany
    {
        return $this->hasMany(Rating::class, 'rater_id');
    }

    public function receivedRatings(): HasMany
    {
        return $this->hasMany(Rating::class, 'rated_user_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class)->latest();
    }

    public function unreadNotificationsCount(): int
    {
        return $this->hasMany(Notification::class)->where('is_read', false)->count();
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class, 'user_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
