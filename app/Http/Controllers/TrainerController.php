<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::with('user')->get();
        return view('trainers.index', compact('trainers'));
    }

    public function book(Request $request)
    {
        $request->validate([
            'trainer_id' => 'required|exists:trainers,id',
            'date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'trainer_id' => $request->trainer_id,
            'date' => $request->date,
            'time_slot' => $request->time_slot,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Booking request sent successfully!');
    }
}
