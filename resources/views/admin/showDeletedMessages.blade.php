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
        <form action="{{ route('admin.showDeletedMessages') }}" method="GET">
            <input type="text" name="search" placeholder="Search by teacher name" value="{{ request('search') }}">
            <input type="date" name="date" placeholder="Search by date" value="{{ request('date') }}">
            <button type="submit">Search</button>
        </form>
        <div class="messages-container">
    <h1>Messages Without Bookings</h1>
    @if($messagesGroupedByBookingId->isEmpty())
    <p class="no-messages">No messages found for deleted bookings.</p> 
@else
    @foreach($messagesGroupedByBookingId as $bookingId => $messages)
        <div class="booking-messages">
            <h3 class="booking-id">Messages for Booking ID: {{ $bookingId }}</h3>
            @foreach($messages as $message)
                <div class="message">
                    <div class="message-header">
                        <span class="message-from">
                            <strong>From ({{ $message->sender->roles }}):</strong> {{ $message->sender->name }}
                        </span>
                        <span class="message-to">
                            <strong>To ({{ $message->receiver->roles }}):</strong> {{ $message->receiver->name }}
                        </span>
                        <span class="message-date">{{ $message->created_at->timezone('Asia/Manila')->format('d M Y g:i A') }}</span>
                    </div>
                    <div class="message-body">{{ $message->message }}</div>
                </div>
            @endforeach
        </div>
    @endforeach
@endif

</div>



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