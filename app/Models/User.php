<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable = [
        'full_name',
        'email',
        'password',
        'cccd_number',
        'role_name',
        'avatar',
        'born_day',
        'born_month',
        'born_year',
        'address',
        'domicile',
        'phone',
        'gender',
        'type',
        'position_index',
        'parent_marriage_id',
        'main_person_id',
        'family_tree_id',
        'is_main',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'full_avatar_path',
        'extra',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userInfo(): HasOne
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'id');
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'user_id', 'id');
    }

    public function funds(): HasMany
    {
        return $this->hasMany(Fund::class, 'user_id', 'id');
    }

    public function eventsUsers(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_user', 'user_id', 'event_id');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function blogsViewers(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blogs_viewers', 'blog_id', 'user_id')->withTimestamps();
    }

    public function familyTree(): BelongsTo
    {
        return $this->belongsTo(FamilyTree::class, 'family_tree_id');
    }

    public function age()
    {
        $age = 0;
        if ($this->attributes['born_year']) {
            $yearOfBirth = $this->attributes['born_year'];
            $currentDate = Carbon::now();
            $age = $currentDate->year - $yearOfBirth;
        }

        return $age;
    }

    public function getFullAvatarPathAttribute()
    {
        if (!empty($this->avatar)) {
            return route('get_avatar_image', $this->avatar);
        }
        
        return "";
    }

    public function getBorn()
    {
        $birthday = '';
        if ($this->attributes['born_year'] != null) {
            $birthday = "Năm sinh: {$this->attributes['born_year']}";
        }
        if ($this->attributes['born_day'] != null && $this->attributes['born_month'] != null) {
            $birthday = "Sinh nhật: {$this->attributes['born_day']}-{$this->attributes['born_month']}";
        }
        if ($this->attributes['born_day'] != null && $this->attributes['born_month'] != null && $this->attributes['born_year'] != null) {
            $birthday = "Ngày sinh: {$this->attributes['born_day']}-{$this->attributes['born_month']}-{$this->attributes['born_year']}";
        }

        return $birthday;
    }

    public function getLeave()
    {
        $leaveday = '';
        if ($this->userInfo->attributes['leave_year'] != null) {
            $leaveday = "Năm mất: {$this->userInfo->attributes['leave_year']}";
        }
        if ($this->userInfo->attributes['leave_day'] != null && $this->userInfo->attributes['leave_month'] != null) {
            $leaveday = "Ngày giỗ: {$this->userInfo->attributes['leave_day']}-{$this->userInfo->attributes['leave_month']}";
        }
        if ($this->userInfo->attributes['leave_day'] != null && $this->userInfo->attributes['leave_month'] != null && $this->userInfo->attributes['leave_year'] != null) {
            $leaveday = "Ngày mất: {$this->userInfo->attributes['leave_day']}-{$this->userInfo->attributes['leave_month']}-{$this->userInfo->attributes['leave_year']}";
        }

        return $leaveday;
    }

    public function countChild()
    {
        $count = 0;
        // Case is main parent
        if ($this->attributes['is_main'] == true) {
            $marriages = $this->marriages;
            foreach ($marriages as $marriage) {
                $count += $this->where('parent_marriage_id', $marriage->id)->count() ?? 0;
            }
        } 
        // Case is spouse parent
        else {
            $count += $this->spouseMarriage->marriageChildrens->count() ?? 0;
        }

        return $count;
    }

    public function getExtraAttribute()
    {
        return [
            'id' => $this->attributes['id'],
            'full_avatar_node' => !empty($this->avatar) ? route('get_avatar_image', $this->avatar) : "",
            'role_name' => $this->attributes['role_name'],
            'full_name' => $this->attributes['full_name'],
            'birthday' => $this->getBorn(),
            'leaveday' => $this->getLeave(),
            'is_main' => $this->attributes['is_main'],
            'child_count' => $this->countChild(),
            'spouse_count' => $this->spouses()->count(),
            'has_parent' => $this->attributes['parent_marriage_id'] != null ? true : false,
            'marriage_id' => $this->marriages->first()->id ?? null,
        ];
    }

    public function video360degrees(): HasMany
    {
        return $this->hasMany(Video360::class, 'user_id', 'id');
    }

    public function vr3D(): HasMany
    {
        return $this->hasMany(Vr3D::class, 'user_id', 'id');
    }

    public function userTokens(): HasMany
    {
        return $this->hasMany(UserToken::class, 'user_id', 'id');
    }

    public function marriages()
    {
        return $this->hasMany(Marriage::class, 'main_person_id');
    }

    /**
     * Use for count child from spouse parent
     * **/
    public function spouseMarriage()
    {
        return $this->belongsTo(Marriage::class, 'id', 'spouse_id');
    }

    public function spouses()
    {
        return $this->hasMany(User::class, 'main_person_id');
    }

    public function mainSpouse()
    {
        return $this->belongsTo(User::class, 'main_person_id');
    }

    public function parentMarriage()
    {
        return $this->belongsTo(Marriage::class, 'parent_marriage_id');
    }
}
