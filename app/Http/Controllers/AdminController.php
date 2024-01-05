<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Message;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $bookings = Booking::with(['student', 'teacher'])->get();
        return view('admin_dashboard', compact('bookings'));
    }


    public function showBookingMessages($bookingId) {
        $booking = Booking::with('messages.sender', 'messages.receiver')->findOrFail($bookingId);
        return view('admin.showMessages', compact('booking'));
    }

    public function showDeletedBookingMessages(Request $request) {
        // Start with a base query
        $query = Message::query();
    
        // If there's a search term, apply filters
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->whereHas('sender', function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', "%{$searchTerm}%")
                          ->where('roles', 'teacher'); 
                })
                ->orWhereHas('receiver', function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', "%{$searchTerm}%")
                          ->where('roles', 'teacher');
                })
                ->orWhereDate('created_at', '=', $searchTerm); 
        }
    
        $messagesGroupedByBookingId = $query->with(['sender', 'receiver'])
                                            ->orderBy('booking_id', 'desc')
                                            ->get()
                                            ->groupBy('booking_id');
    
        return view('admin.showDeletedMessages', compact('messagesGroupedByBookingId'));
    }
    
    
    
    
    
}
