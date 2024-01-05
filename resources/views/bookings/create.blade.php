<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Create Bookings</title>
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
          <h1>Book a Schedule</h1>
          <table class="table">
            <thead>
              <tr>
                <th>Booking with</th>
                <th>Schedule</th>
                <th>From</th>
                <th>To</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <form action="{{ route('bookings.store') }}" method="POST">
            @csrf
            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
            <input type="hidden" name="teacher_id" value="{{ $schedule->teacher_id }}">
              <tr>
                <td>{{ $schedule->teacher->name }}</td>
                <td>{{ $schedule->day }}</td>
                <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}</td>
                <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</td> 
                <td><button type="submit">Book Now</button></td>
              </tr>
            </form>
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