<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FamilyTree extends Model
{
    use HasFactory;
    protected $table = 'family_trees';
    protected $fillable = [
        'title',
        'template_id',
        'description',
        'root_admin_id',
        'audio_link',
        'domain',
        'is_approve_trial',
        'max_member_trial',
        'expired_at_trial',
    ];

    public function contactInfo(): HasOne
    {
        return $this->hasOne(ContactInfo::class, 'family_tree_id', 'id');
    }
}
