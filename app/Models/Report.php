<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id', 'food_post_id', 'skill_post_id', 'reason', 'details', 'status',
    ];

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
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
