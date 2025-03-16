<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostTemplate extends Model
{
    protected $fillable = ['title', 'headline', 'message', 'link'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
