<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostCommentReaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'comment_id',
        'type'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comment():BelongsTo
    {
        return $this->belongsTo(PostComment::class, 'comment_id');
    }
}
