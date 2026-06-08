<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $fillable = ['image_path', 'order'];

    public function imageable()
    {
        return $this->morphTo();
    }
}
