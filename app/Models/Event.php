<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $fillable = [
        'title',
        'date',
        'description',
        'detail',
        'is_year_loop',
        'family_tree_id',
        'user_id',
        'noti_before_at',
        'noti_before',
        'created_at',
        'updated_at',
    ];

    public function eventTimes(): HasMany
    {
        return $this->hasMany(EventTime::class, 'event_id', 'id');
    }

    public function eventsUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function eventsViewers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'events_viewers', 'event_id', 'user_id')->withTimestamps();
    }
}
