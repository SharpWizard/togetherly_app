<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'food_post_id', 'skill_post_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function foodPost(): BelongsTo
    {
        return $this->belongsTo(FoodPost::class);
    }

    public function skillPost(): BelongsTo
    {
        return $this->belongsTo(SkillPost::class);
    }

    public static function hasFood(int $foodPostId): bool
    {
        if (! auth()->check()) {
            return false;
        }
        return static::where('user_id', auth()->id())->where('food_post_id', $foodPostId)->exists();
    }

    public static function hasSkill(int $skillPostId): bool
    {
        if (! auth()->check()) {
            return false;
        }
        return static::where('user_id', auth()->id())->where('skill_post_id', $skillPostId)->exists();
    }
}

