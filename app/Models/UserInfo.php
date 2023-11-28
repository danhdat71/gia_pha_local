<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = 'user_infos';

    public $fillable = [
        'cccd_image_before',
        'cccd_image_after',
        'job',
        'position',
        'organization',
        'cert_images',
        'leave_day',
        'leave_month',
        'leave_year',
        'rest_place',
        'lat',
        'long',
        'rest_images',
        'user_id',
        'story',
        'video_360_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
