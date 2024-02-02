<?php

namespace App\Models;

use App\Enums\ReportsType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'comment'
    ];

    protected $cast = [
        'parent_id'=> 'boolean:integer'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function parent():BelongsTo
    {
        return $this->belongsTo(PostComment::class);
    }

    public function answers():HasMany
    {
        return $this->hasMany(PostComment::class, 'parent_id');
    }

    public function reactions():HasMany
    {
        return $this->hasMany(PostCommentReaction::class);
    }

    public function reports():HasMany
    {
        return $this->hasMany(PostCommentReport::class, 'comment_id');
    }

    public function scopeWithReactionCounts(Builder $query)
    {
        return $query
            ->select('post_comments.*')
            ->selectSub(function ($query) {
                $query->from('post_comment_reactions')
                    ->selectRaw(' COUNT(CASE WHEN type = "LIKE" THEN 1 ELSE 0 END) as like_count')
                    ->whereColumn('comment_id', 'post_comments.id')
                    ->where('type', 'LIKE')
                    ->groupBy('comment_id');
            }, 'like_count')
            ->selectSub(function ($query) {
                $query->from('post_comment_reactions')
                    ->selectRaw('COUNT(CASE WHEN type = "UNLIKE" THEN 1 ELSE 0 END) as unlike_count')
                    ->whereColumn('comment_id', 'post_comments.id')
                    ->where('type', 'UNLIKE')
                    ->groupBy('comment_id');
            }, 'unlike_count');
    }

    public function scopeWithUserReaction(Builder $query)
    {
        return $query->selectSub(function($query){
            $query
                ->from('post_comment_reactions')
                ->select('type')
                ->whereColumn('comment_id', 'post_comments.id')
                ->where('user_id', auth()->check() ? auth()->id() : null);
        }, 'user_reaction');
    }

    public function scopeWithCommentToPublic(Builder $query)
    {
        return $query
            ->with('user')
            ->withReactionCounts()
            ->withUserReaction()
            ->where(function (Builder $commentQuery) {
                $commentQuery->doesntHave('reports')
                    ->orWhereHas(
                        'reports',
                        function (Builder $reportQuery) {
                        $reportQuery->where('status', '!=', ReportsType::APPROVED);
                        }
                    );
            });
    }
}
