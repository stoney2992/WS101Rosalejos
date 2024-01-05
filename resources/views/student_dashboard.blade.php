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
        <li><a href="{{ route('student_dashboard') }}"> 
          <i class="fas fa-menorah"></i>
          <span class="nav-item">Dashboard</span>
        </a></li>
        <li><a href="{{ route('students.viewTeachers') }}"> 
          <i class="fas fa-chart-bar"></i>
          <span class="nav-item">Teacher Schedules</span>
        </a></li>
        <li><a href="{{ route('bookings.studentBookings') }}"> 
          <i class="fas fa-chart-bar"></i>
          <span class="nav-item">Booked Schedule</span>
        </a></li>
        <li>
    <a href="">
        <i class="fas fa-chart-bar"></i>
        <span class="nav-item">Chat</span>
    </a>
</li>

        <li><a href="{{ route('logout') }}" class="logout">
          <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Log out</span>
        </a></li>
      </ul>
    </nav>


    <section class="main">

      <section class="attendance">
        <div class="attendance-list">
          <h1>Student Dashboard</h1>
          <table class="table">
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