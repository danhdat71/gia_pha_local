<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vr3D extends Model
{
    use HasFactory;
    public $table = 'vr_3ds';
    public $fillable = [
        'user_id',
        'url',
    ];
    protected $appends = [
        'full_link',
    ];

    public function vr3Dbuttons(): HasMany
    {
        return $this->hasMany(Vr3DButton::class, 'vr_3d_id', 'id');
    }

    public function getFullLinkAttribute()
    {
        return route('get_vr_3d', $this->url);
    }
}
