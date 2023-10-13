<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email',
        'token'
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
