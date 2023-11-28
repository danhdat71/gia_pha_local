<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactInfo extends Model
{
    use HasFactory;
    protected $table = 'contact_infos';
    protected $fillable = [
        'phone',
        'email',
        'address',
        'contact_person',
        'position',
        'family_tree_id',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(FamilyTree::class, 'family_tree_id');
    }
}
