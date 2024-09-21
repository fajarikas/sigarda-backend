<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    public function scheduleDetails()
    {
        return $this->hasMany(ScheduleDetail::class);
    }

    public function scheduleUsers()
    {
        return $this->hasMany(ScheduledUser::class);
    }
}
