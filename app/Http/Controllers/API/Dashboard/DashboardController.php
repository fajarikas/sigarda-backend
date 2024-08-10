<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = User::count();
            $men = User::where('gender', '=', 'men')->count();
            $women = User::where('gender', '=', 'women')->count();

            $planning = Project::where('status', '=', 'planning')->count();
            $onprogress = Project::where('status', '=', 'on progress')->count();
            $completed = Project::where('status', '=', 'completed')->count();

            $projectsByMonth = Project::selectRaw('MONTH(start) as month, YEAR(start) as year, COUNT(*) as count')
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();

            $monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

            $formattedProjectsByMonth = $projectsByMonth->mapWithKeys(function ($item) use ($monthNames) {
                $month = (int) $item->month;
                $year = (int) $item->year;
                $monthName = $monthNames[$month - 1];
                $formattedDate = "$monthName ";

                return [$formattedDate => $item->count];
            })->toArray();

            return response()->json([
                'message' => 'Success',
                'data' => [
                    'user' => $user,
                    'men' => $men,
                    'women' => $women,
                    'project' => [
                        'planning' => $planning,
                        'progress' => $onprogress,
                        'completed' => $completed
                    ],
                    'projectsByMonth' => $formattedProjectsByMonth
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
