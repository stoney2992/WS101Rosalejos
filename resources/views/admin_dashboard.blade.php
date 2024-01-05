<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
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
        <li><a href="{{ route('dashboard') }}"> 
          <i class="fas fa-menorah"></i>
          <span class="nav-item">Dashboard</span>
        </a></li>
        <li><a href="{{ route('admin.showDeletedMessages') }}"> 
          <i class="fas fa-chart-bar"></i>
          <span class="nav-item">View Saved Chats</span>
        </a></li>
        <li><a href="{{ route('admin.users.index') }}"> 
          <i class="fas fa-chart-bar"></i>
          <span class="nav-item">View Users</span>
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
          <h1>Admin Dashboard</h1>
          <table class="table">
          <div class="bookings-container">
    @foreach($bookings as $booking)
        <div class="booking-card">
            <div class="booking-info">
                <h2 class="booking-title">Booking ID: {{ $booking->id }}</h2>
                <p class="booking-teacher"><strong>Teacher:</strong> {{ $booking->teacher->name }}</p>
                <p class="booking-student"><strong>Student:</strong> {{ $booking->student->name }}</p>
            </div>
            <div class="booking-action">
                <a href="{{ route('admin.booking.messages', $booking->id) }}" class="view-messages-btn">View Messages</a>
            </div>
        </div>
    @endforeach
</div>

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