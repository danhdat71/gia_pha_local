<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marriage extends Model
{
    use HasFactory;

    public $table = 'marriages';

    protected $fillable = [
        'main_person_id',
        'spouse_id',
        'parent_marriage_id',
    ];

    public function spouse()
    {
        return $this->belongsTo(User::class, 'spouse_id');
    }

    public function children()
    {
        return $this->hasMany(User::class, 'parent_marriage_id')->with([
            'marriages.children',
            'marriages.spouse',
        ]);
    }

    public function marriageChildrens()
    {
        return $this->hasMany(User::class, 'parent_marriage_id', 'id');
    }

    public function mainPerson()
    {
        return $this->belongsTo(User::class, 'main_person_id');
    }
}
