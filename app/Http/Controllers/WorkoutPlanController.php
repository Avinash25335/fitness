<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use App\Models\WorkoutLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutPlanController extends Controller
{
    public function index()
    {
        // Eager-load exercise count so the view can display it without N+1 queries
        $workouts = WorkoutPlan::withCount('exercises')
            ->orderBy('level') // beginner → intermediate → advanced
            ->get();

        // If the user is logged in, figure out which plans they have already logged
        $loggedPlanIds = collect();
        $planProgress = [];
        $activePlanId = null;

        if (Auth::check()) {
            $logs = WorkoutLog::where('user_id', Auth::id())->get();
            $loggedPlanIds = $logs->pluck('workout_plan_id')->unique();
            
            foreach ($loggedPlanIds as $id) {
                $planProgress[$id] = $logs->where('workout_plan_id', $id)->count();
            }

            $activePlanId = WorkoutLog::where('user_id', Auth::id())
                ->latest()
                ->value('workout_plan_id');
        }

        return view('workouts.index', compact('workouts', 'loggedPlanIds', 'activePlanId', 'planProgress'));
    }

    public function show(WorkoutPlan $workout)
    {
        $workout->load(['exercises' => function ($q) {
            $q->orderBy('workout_exercise.order');
        }]);

        // Check if the current user has already logged this plan
        $alreadyStarted = false;
        if (Auth::check()) {
            $alreadyStarted = WorkoutLog::where('user_id', Auth::id())
                ->where('workout_plan_id', $workout->id)
                ->exists();
        }

        return view('workouts.show', compact('workout', 'alreadyStarted'));
    }
}
