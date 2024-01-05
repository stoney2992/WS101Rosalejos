<?php

namespace App\Http\Controllers;
use Carbon\Carbon;


use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

    public function create($scheduleId)
    {
        $schedule = Schedule::with('teacher')->findOrFail($scheduleId);

        return view('bookings.create', compact('schedule'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        Booking::create([
            'student_id' => Auth::id(),
            'teacher_id' => $request->teacher_id,
            'schedule_id' => $request->schedule_id, 
            'status' => 'pending', 
        ]);

        // Redirect the user with a success message
        return redirect()->route('bookings.studentBookings')->with('success', 'Booking created successfully');
    }



    public function viewStudentBookings()
{
    $bookings = Booking::where('student_id', Auth::id())->get();
    return view('bookings.studentBookings', compact('bookings'));
}



public function viewTeacherBookings()
{
    $bookings = Booking::where('teacher_id', Auth::id())->get();    
    return view('bookings.teacherBookings', compact('bookings'));
}



public function updateStatus(Request $request, $bookingId)
{
    $booking = Booking::findOrFail($bookingId);
    $booking->update(['status' => $request->status]); 

    return back()->with('success', 'Booking status updated.');
}



public function destroy($bookingId)
{
    $booking = Booking::findOrFail($bookingId);

    if (Auth::id() != $booking->student_id && Auth::id() != $booking->teacher_id) {
        return back()->with('error', 'Unauthorized action.');
    }

    // Don't delete messages, the foreign key constraint should handle setting their booking_id to NULL
    // Message::where('booking_id', $booking->id)->delete();

    $booking->delete();
    return redirect()->back()->with('success', 'Booking cancelled successfully.');
}




public function show(Booking $booking) 
    {
        // Load the booking with its related messages
        $booking->load('messages.sender', 'messages.receiver');

        // Return the detail view with the booking data
        return view('bookings.detail', compact('booking'));
    }


    public function getMessages(Booking $booking)
{
    $messages = $booking->load('messages.sender', 'messages.receiver')->messages;
    return response()->json($messages);
}




}

