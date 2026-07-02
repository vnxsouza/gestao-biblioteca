<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'author',
        'genre',
        'status',
        'rating',
        'notes',
        'pages',
    ];

    protected $casts = [
        'rating' => 'integer',
        'pages' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeStatus($query, ?string $status)
    {
        return $status ? $query->where('status', $status) : $query;
    }

    public function scopeSearch($query, ?string $term)
    {
        return $term
            ? $query->where(fn ($q) => $q->where('title', 'like', "%{$term}%")
                                          ->orWhere('author', 'like', "%{$term}%"))
            : $query;
    }
}