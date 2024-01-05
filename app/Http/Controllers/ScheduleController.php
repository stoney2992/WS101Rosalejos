<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\User; // Ensure this is included if you're referencing the User model

class ScheduleController extends Controller
{
    // Display a list of schedules
    public function index()
    {
        $user = auth()->user();

        $schedules = Schedule::where('teacher_id', $user->id)->get(); // You might want to filter this based on the logged-in teacher
        return view('schedules.index', compact('schedules'));
    }

    // Show the form for creating a new schedule
    public function create()
    {
        return view('schedules.create');
    }

    // Store a newly created schedule in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        Schedule::create($validatedData);
        return redirect()->route('schedules.index');
    }

    // Show the form for editing the specified schedule
    public function edit(Schedule $schedule)
    {
        return view('schedules.edit', compact('schedule'));
    }

    // Update the specified schedule in the database
    public function update(Request $request, Schedule $schedule)
    {
        $validatedData = $request->validate([
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        $schedule->update($validatedData);
        return redirect()->route('schedules.index');
    }

    // Remove the specified schedule from the database
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index');
    }
}


