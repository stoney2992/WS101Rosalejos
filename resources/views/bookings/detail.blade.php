<span style="font-family: verdana, geneva, sans-serif;"><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Teacher Bookings</title>
  <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/chat-design.css') }}">
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
          <span class="nav-item">Teacher Dashboard</span>
        </a></li>
        <li><a href="{{ route('students.viewTeachers') }}"> 
          <i class="fas fa-menorah"></i>
          <span class="nav-item">Student Dashboard</span>
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
          
        <div class="chat-container">
    <div class="chat-header">
        <h2>Chat with {{ $booking->teacher->name }}</h2>
        <div class="chat-schedule">
            <span>{{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('g:i A') }} on {{ $booking->schedule->day }}</span>
            <span class="chat-status">{{ $booking->status }}</span>
        </div>
    </div>

          <hr>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone-with-data.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var scheduledDay = "{{ $booking->schedule->day }}";
    var currentDay = moment().tz("Asia/Manila").format('dddd');

    var startTimeString = moment().format('YYYY-MM-DD') + "T" + "{{ $booking->schedule->start_time }}";
    var endTimeString = moment().format('YYYY-MM-DD') + "T" + "{{ $booking->schedule->end_time }}";

    // Make sure that the server is sending the correct format for times
    console.log("Start Time String:", startTimeString);
    console.log("End Time String:", endTimeString);

    var startTime = moment.tz(startTimeString, "YYYY-MM-DDTHH:mm:ss", "Asia/Manila");
    var endTime = moment.tz(endTimeString, "YYYY-MM-DDTHH:mm:ss", "Asia/Manila");

    // If the end time is before the start time, assume it ends the next day.
    if (endTime.isBefore(startTime)) {
      endTime.add(1, 'day');
    }

    // Log the calculated start and end times for debugging
    console.log("Calculated Start Time:", startTime.format());
    console.log("Calculated End Time:", endTime.format());

    var isCorrectDay = currentDay.toLowerCase() === scheduledDay.toLowerCase();
    var currentTime = moment().tz("Asia/Manila");
    var isTimeValid = currentTime.isBetween(startTime, endTime, null, '[]'); // Include both start and end times  

    // Log the current time and the evaluation of day and time for debugging
    console.log("Current Time:", currentTime.format());
    console.log("Is Correct Day:", isCorrectDay);
    console.log("Is Time Valid:", isTimeValid);

    var chatForm = document.getElementById("chatForm");
    var chatDisabledMessage = document.getElementById("chatDisabledMessage");

    if (!isCorrectDay || !isTimeValid) {
        if (chatForm) {
            chatForm.style.display = "none";
            document.querySelector("#chatForm textarea").disabled = true;
            document.querySelector("#chatForm button").disabled = true;
        }
        chatDisabledMessage.textContent = !isCorrectDay ? 
            "Chat is not available today. Please come back on " + scheduledDay :
            "Chat is not available outside the scheduled time.";
        chatDisabledMessage.style.display = "block";
    } else {
        if (chatForm) {
            chatForm.style.display = "block";
        }
        chatDisabledMessage.style.display = "none";
    }

    // Update message timestamps to local time
    document.querySelectorAll('.message-time').forEach(function(span) {
        var serverTime = span.getAttribute('data-server-time');
        var localTime = moment(serverTime).local().format('DD MMM YYYY, hh:mm A'); // Convert to 12-hour format
        span.textContent = localTime;
    });
});
</script>




<script>
    function fetchMessages() {
        fetch("{{ route('bookings.getMessages', $booking->id) }}")
            .then(response => response.json())
            .then(messages => {
                let messagesContainer = document.querySelector('.chat-messages');
                messagesContainer.innerHTML = ''; 
                messages.forEach(message => {
                    let messageDiv = document.createElement('div');
                    messageDiv.classList.add(message.sender_id == {{ Auth::id() }} ? 'sent' : 'received');
                    messageDiv.innerHTML = `
                        <strong>${message.sender.name}:</strong>
                        <p>${message.message}</p>
                        <span>${new Date(message.created_at).toLocaleTimeString()}</span>
                    `;
                    messagesContainer.appendChild(messageDiv);
                });
            })
            .catch(error => console.error('Error fetching messages:', error));
    }

    // Fetch messages every 5 seconds
    setInterval(fetchMessages, 4000);

    // Call it once on page load as well
    fetchMessages();

    
</script>

<script>
    function scrollToBottom() {
        const chatMessages = document.querySelector('.chat-messages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    document.addEventListener('DOMContentLoaded', scrollToBottom);
</script>


<div class="chat-messages">
        @forelse ($booking->messages as $message)
            <div class="chat-message {{ $message->sender_id == Auth::id() ? 'chat-sent' : 'chat-received' }}">
                <strong>{{ $message->sender->name }}:</strong>
                <p>{{ $message->message }}</p>
                <div class="chat-timestamp">{{ $message->created_at->timezone('Asia/Manila')->format('g:i A') }}</div>
            </div>
        @empty
            <div class="chat-no-messages">No messages yet.</div>
        @endforelse
    </div>

          <!-- Disabled Chat Message -->
          <div id="chatDisabledMessage" style="display: none;">
            <p>Chat is not available. The scheduled time for this booking has ended.</p>
          </div>

          <hr>

          <!-- Form for sending a new message -->
        <div class="chat-form">
            <form id="chatForm" action="{{ route('message.store') }}" method="POST">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                <textarea name="message" placeholder="Type your message here" required></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
</div>


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