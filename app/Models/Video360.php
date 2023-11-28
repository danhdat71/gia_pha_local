<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video360 extends Model
{
    use HasFactory;
    public $table = 'video_360_degrees';
    public $fillable = [
        'user_id',
        'url',
    ];
}
