<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partner extends Model
{
    protected $fillable = ['id', 'name', 'website', 'phone', 'country'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
