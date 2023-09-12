<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'sub_title',
        'slug',
        'content',
        'image_url',
        'category_id',
        'author_id',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $casts = [

    ];

    public function category():BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function author():BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function reactions():HasMany
    {
        return $this->hasMany(PostReaction::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class);
    }

    public function scopeWithPostReactionCounts(Builder $query)
    {
        return $query->select('posts.*')
            ->selectSub(function ($query) {
                $query->from('post_reactions')
                    ->selectRaw(' COUNT(CASE WHEN type = "LIKE" THEN 1 ELSE 0 END) as like_count')
                    ->whereColumn('post_id', 'posts.id')
                    ->where('type', 'LIKE')
                    ->groupBy('post_id');
            }, 'like_count')
            ->selectSub(function ($query) {
                $query->from('post_reactions')
                    ->selectRaw('COUNT(CASE WHEN type = "UNLIKE" THEN 1 ELSE 0 END) as unlike_count')
                    ->whereColumn('post_id', 'posts.id')
                    ->where('type', 'UNLIKE')
                    ->groupBy('post_id');
            }, 'unlike_count');
    }

}
