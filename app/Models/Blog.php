<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'avatar',
        'content',
        'is_visible',
        'user_id',
        'family_tree_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function blogsViewers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'blogs_viewers', 'blog_id', 'user_id')->withTimestamps();
    }
}
