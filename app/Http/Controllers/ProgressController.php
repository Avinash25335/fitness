<?php

namespace App\Http\Controllers;

use App\Models\ProgressLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProgressController extends Controller
{
    /**
     * Show the progress tracker page.
     */
    public function index()
    {
        $user       = Auth::user();
        $profile    = $user->profile;
        $progressLogs = $user->progressLogs()->orderBy('log_date', 'asc')->get();

        return view('progress.index', compact('user', 'profile', 'progressLogs'));
    }

    /**
     * Store a new progress log entry.
     */
    public function store(Request $request)
    {
        $request->validate([
            'weight'   => 'required|numeric|min:10|max:500',
            'log_date' => 'required|date|before_or_equal:today',
            'image'    => 'nullable|image|max:4096',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('transformations', 'public');
        }

        ProgressLog::updateOrCreate(
            [
                'user_id'  => Auth::id(),
                'log_date' => $request->log_date,
            ],
            [
                'weight'               => $request->weight,
                'transformation_image' => $imagePath ?? ProgressLog::where('user_id', Auth::id())
                                            ->where('log_date', $request->log_date)
                                            ->value('transformation_image'),
            ]
        );

        // Keep profile weight in sync
        $profile = Auth::user()->profile;
        if ($profile && $profile->height > 0) {
            $heightMeters = $profile->height / 100;
            $bmi = round($request->weight / ($heightMeters * $heightMeters), 2);
            $profile->update([
                'weight' => $request->weight,
                'bmi'    => $bmi,
            ]);
        }

        return back()->with('success', 'Progress entry saved!');
    }
}
