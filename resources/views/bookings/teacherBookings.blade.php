<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Teacher Bookings</title>
  <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}">
  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
  <div class="container">
    <nav>
      <ul>
        <li><a href="#" class="logo">
          <span class="nav-item">{{ session('name') }}</span>
        </a></li>
        <li><a href="{{ route('schedules.index') }}"> 
          <i class="fas fa-menorah"></i>
          <span class="nav-item">Dashboard</span>
        </a></li>
        <li><a href="{{ route('schedules.create') }}">
          <i class="fas fa-chart-bar"></i>
          <span class="nav-item">Create Schedule</span>
        </a></li>
        <li><a href="{{ route('bookings.teacherBookings') }}"> 
          <i class="fas fa-chart-bar"></i>
          <span class="nav-item">Booked Schedules</span>
        </a></li>

        <li><a href="{{ route('logout') }}" class="logout">
          <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Log out</span>
        </a></li>
      </ul>
    </nav>


    <section class="main">

      <section class="attendance">
        <div class="attendance-list">
          <h1>Bookings with You</h1>
          <table class="table">
            <thead>
              <tr>
                <th>Student</th>
                <th>Schedule</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Confirm</th>
                <th>Delete</th>
                <th>Chat</th>
              </tr>
            </thead> 
            <tbody>
            @forelse($bookings as $booking)
              <tr>
                <td>{{ $booking->student->name }}</td>
                <td>{{ $booking->schedule->day }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('g:i A') }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('g:i A') }}</td> 
                <td>{{ $booking->status }}</td>
                <td>
                <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST">
                @csrf
                    <select name="status">
                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirm</option>
                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancel</option>
                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                <button type="submit">Update Status</button>
                </form>
                </td>
                <td>
                @if($booking->status == 'pending')
                Chat not available
                @else
                  <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" onclick="return confirm('Are you sure you want to cancel this booking?');">Delete</button>
                  </form>
                  </td>
                  
                  
                  <td>
                <a href="{{ route('bookings.show', $booking->id) }}" class="chat-link"><button>Chat</button></a>
                </td>
                @endif
              </tr>
              @empty
                  <p>No bookings yet.</p>
              @endforelse
            </tbody>
          </table>
        </div>
      </section>
    </section>
  </div>

  <footer>
    <p>&copy; Developed by: Stoney Rosalejos</p>
  </footer>

</body>
</html>
</span>