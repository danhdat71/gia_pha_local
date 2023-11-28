<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class EventTime extends Model
{
    use HasFactory;
    protected $table = 'event_times';
    protected $fillable = [
        'start_at',
        'end_at',
        'description',
        'event_id',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function getStartAtAttribute($value)
    {
        $date = Carbon::createFromFormat('H:i:s', $value);
        return $date->format('H:i');
    }

    public function getEndAtAttribute($value)
    {
        $date = Carbon::createFromFormat('H:i:s', $value);
        return $date->format('H:i');
    }
}
