<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Student Dashboard</title>
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
        <li><a href="{{ route('students.viewTeachers') }}"> 
          <i class="fas fa-menorah"></i>
          <span class="nav-item">Dashboard</span>
        </a></li>
        <li><a href="{{ route('bookings.studentBookings') }}"> 
          <i class="fas fa-chart-bar"></i>
          <span class="nav-item">Booked Schedule</span>
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
          <h1>Your Bookings</h1>
          <table class="table">
            <thead>
              <tr>
                <th>Teacher</th>
                <th>Schedule</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Action</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            @forelse($bookings as $booking)
              <tr>
                <td>{{ $booking->teacher->name }}</td>
                <td>{{ $booking->schedule->day }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('g:i A') }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('g:i A') }}</td> 
                <td>{{ $booking->status }}</td>
                <td>
                @if($booking->status == 'pending') <!-- Assuming 'pending' status can be cancelled -->
                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Cancel Booking</button>
                </form>
                @else
                </td>
                <td>
                <a href="{{ route('bookings.show', $booking->id) }}" class="chat-link"><button>Chat</button></a>
                </td>
                @endif
              </tr>
              @empty
                <p>No bookings made yet.</p>
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