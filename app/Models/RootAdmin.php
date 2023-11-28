<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class RootAdmin extends Authenticatable
{
    use HasFactory;

    protected $table = 'root_admins';

    protected $fillable = [
        'full_name',
        'username',
        'password',
        'created_at',
        'updated_at',
    ];
}
