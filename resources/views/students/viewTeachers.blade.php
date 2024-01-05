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
          <h1>Teachers' Schedules</h1>
          <table class="table">
          @if ($teachers->every(fn($teacher) => $teacher->schedules->isEmpty()))
              <p>No Schedules Available.</p>
          @else
            <thead>
              <tr>
                <th>Teacher Name</th>
                <th>Day:</th>
                <th>Start Time:</th>
                <th>End Time:</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
              @foreach ($teachers as $teacher)
            {{-- Now check if the individual teacher has schedules --}}
            @if ($teacher->schedules->isNotEmpty())
                
                @foreach ($teacher->schedules as $schedule)
                    <tr>
                        <td>{{ $teacher->name }}</td>
                        <td>{{ $schedule->day }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</td> 
                        <td>
                            {{-- Assuming you have a route to book the schedule --}}
                            <a href="{{ route('bookings.create', $schedule->id) }}">Book This Schedule</a>
                        </td>
                    </tr>
                                 @endforeach
                             @endif
                         @endforeach
                 @endif
              </tr>
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