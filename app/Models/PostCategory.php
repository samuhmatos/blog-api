<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function posts():HasMany
    {
        return $this->hasMany(Post::class,'category_id');
    }

    public function scopePostsCount(Builder $query)
    {
        return $query->withCount('posts');
    }
}
