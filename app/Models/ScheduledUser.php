<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'schedule_id',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
    public function scheduleDetails()
    {
        return $this->hasMany(ScheduleDetail::class, 'scheduled_user_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
