<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{


    protected $table = 'schedule_details';
    protected $fillable = [
        'schedule_id',
        'date',
        'shift',
    ];
    use HasFactory;

    public function scheduledUser()
    {
        return $this->belongsTo(ScheduledUser::class, 'scheduled_user_id');
    }
}
