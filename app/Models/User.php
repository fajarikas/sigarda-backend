<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'gender'
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function shift_change()
    {
        return $this->hasMany(ShiftChange::class);
    }

    public function meeting()
    {
        return $this->hasMany(Meeting::class);
    }

    public function presence()
    {
        return $this->hasMany(Presence::class);
    }

    public function notification()
    {
        return $this->hasMany(Notification::class);
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

    public function scheduled_user()
    {
        return $this->hasMany(ScheduledUser::class);
    }
}
