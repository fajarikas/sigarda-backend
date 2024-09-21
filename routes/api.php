    <?php

    use App\Http\Controllers\API\Auth\AuthController;
    use App\Http\Controllers\API\Dashboard\DashboardController;
    use App\Http\Controllers\API\Location\LocationController;
    use App\Http\Controllers\API\Meeting\MeetingController;
    use App\Http\Controllers\API\Notification\NotificationController;
    use App\Http\Controllers\API\Project\ProjectController;
    use App\Http\Controllers\API\Schedule\ScheduleController;
    use App\Http\Controllers\API\ScheduleAPI\ScheduleAPIController;
    use App\Http\Controllers\ScheduleDetailController;
    use App\Http\Controllers\API\Schedule\ScheduledUserController;
    use App\Http\Controllers\ShiftChangeController;
    use App\Http\Controllers\API\User\UserController;
    use App\Http\Controllers\PresenceController;
    use App\Http\Controllers\ShiftController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider and all of them will
    | be assigned to the "api" middleware group. Make something great!
    |
    */

    // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //     return $request->user();
    // });

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    // Route::post('/login', function (Request $request) {
    //     // Validasi request

    // });


    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::resource('/user', UserController::class);
        Route::resource('/project', ProjectController::class);
        Route::resource('/meeting', MeetingController::class);
        Route::resource('/presence', PresenceController::class);
        route::resource('/shift', ShiftController::class);
        route::resource('/shift-change', ShiftChangeController::class);
        route::resource('/notification', NotificationController::class);
        route::resource('/schedule', ScheduleController::class);
        route::resource('/scheduled/user', ScheduledUserController::class);
        Route::resource('/location', LocationController::class);
        Route::resource('/dashboard', DashboardController::class);
        Route::resource('/schedule-detail', ScheduleDetailController::class);
        Route::get('/user/{userId}/schedule', [ScheduleAPIController::class, 'getUserSchedule']);
        Route::get('/schedule-detail/schedule/{schedule_id}', [ScheduleDetailController::class, 'getByScheduleId']);
    });
