<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Schedule</title>
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
          <h1>Schedules List</h1>
          <table class="table">
            <thead>
              <tr>
                <th>Day:</th>
                <th>Start Time:</th>
                <th>End Time:</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($schedules as $schedule)
              <tr>
                <td>{{ $schedule->day }}</td>
                <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}</td>
                <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</td>
                <td>
                    <a href="{{ route('schedules.edit', $schedule) }}">Edit</a> 
                    <form action="{{ route('schedules.destroy', $schedule) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
              </tr>
            </tbody>
          @endforeach
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