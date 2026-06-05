<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'app_notifications';

    protected $fillable = [
        'user_id', 'type', 'title', 'body', 'link', 'icon', 'is_read', 'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quick helper to create a notification for a user.
     */
    public static function notify(int $userId, string $type, string $title, ?string $body = null, ?string $link = null, string $icon = 'fa-bell'): void
    {
        // Never notify yourself
        if ($userId === auth()->id()) {
            return;
        }

        static::create([
            'user_id' => $userId,
            'type'    => $type,
            'title'   => $title,
            'body'    => $body,
            'link'    => $link,
            'icon'    => $icon,
        ]);
    }
}
