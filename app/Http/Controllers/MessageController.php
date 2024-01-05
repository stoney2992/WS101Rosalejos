<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MessageController extends Controller
{

    public function index()
    {
        $messages = Message::all(); 
        return view('message.index', compact('messages'));
    }

    // Store messages
    /**
     * Store a newly created message in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'message' => 'required|string',
            'booking_id' => 'required|exists:bookings,id'
        ]);

        // Create the message
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->determineReceiverId($request->booking_id),
            'message' => $request->message,
            'booking_id' => $request->booking_id,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully.');
    }

    /**
     * Determine the receiver of the message based on the booking.
     *
     * @param  int  $bookingId
     * @return int
     */

     private function determineReceiverId($bookingId)
{
    $booking = Booking::findOrFail($bookingId);
    $currentUserId = Auth::id();

    if ($currentUserId === $booking->student_id) {

        return $booking->teacher_id;
    } else {
        
        return $booking->student_id;
    }
}


}

