<?php

namespace App\Http\Controllers\API\ScheduleAPI;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\ScheduledUser;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleAPIController extends Controller
{
    public function getUserSchedule($userId)
    {
        $user = User::findOrFail($userId);

        $scheduleDetails = Schedule::whereHas('scheduleUsers', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with(['scheduleDetails' => function ($query) {
            $query->orderBy('date');
        }])->get();

        $formattedSchedules = $scheduleDetails->map(function ($schedule) {
            return [
                'schedule_id' => $schedule->id,
                'schedule_name' => $schedule->name, // Assuming schedules have a name
                'details' => $schedule->scheduleDetails->map(function ($detail) {
                    return [
                        'date' => $detail->date,
                        'shift' => $detail->shift
                    ];
                })
            ];
        });

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name
            ],
            'schedules' => $formattedSchedules
        ]);
    }
}
