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
          @foreach ($messages as $message)
    <div class="message">
        <strong>{{ $message->sender->name }}:</strong>
        {{ $message->message }}
    </div>
@endforeach

<!-- Form for sending a message -->
<form action="{{ route('message.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="message">Message:</label>
        <input type="text" name="message" id="message" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Send</button>
</form>
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