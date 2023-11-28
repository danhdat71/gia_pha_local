<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vr3DButton extends Model
{
    use HasFactory;
    
    public $table = 'vr_3d_buttons';

    protected $fillable = [
        'title',
        'button_x',
        'button_y',
        'button_z',
        'vr_3d_id',
        'to_vr_3d_id',
    ];

    public function fromVr3D(): BelongsTo
    {
        return $this->belongsTo(Vr3D::class, 'vr_3d_id');
    }

    public function toVr3D(): BelongsTo
    {
        return $this->belongsTo(Vr3D::class, 'to_vr_3d_id');
    }
}
