<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'avatar',
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'owner_id')->latest('updated_at');
    }

    public function accessibleProjects($search = null)
    {
        return Project::where('owner_id', $this->id)
            ->where('title', 'like', '%' . request('search') . '%')
            ->orWhereHas('members', function ($query) {
                $query->where('user_id', $this->id);
            })->paginate(6);
    }

    public function path($append = ''){

        $path = "/profiles/" . $this->username;

        return $append ? "{$path}/{$append}" : $path;
    }

//    public function setPasswordAttribute($value)
//    {
//        $this->attributes['password'] = bcrypt($value);
//    }

    public function getAvatarAttribute($value)
    {
        return asset('storage/' . $value);
    }
}
