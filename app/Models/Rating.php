<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'rater_id',
        'rated_user_id',
        'food_post_id',
        'skill_post_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function rater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rater_id');
    }

    public function ratedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rated_user_id');
    }

    public function foodPost(): BelongsTo
    {
        return $this->belongsTo(FoodPost::class);
    }

    public function skillPost(): BelongsTo
    {
        return $this->belongsTo(SkillPost::class);
    }
}
