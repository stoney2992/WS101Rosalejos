<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookChat</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{url('/css/loginRegister.css')}}">
</head>
<body>
    <div class="container-heads">
        <form action="{{ route('login_action') }}" method="POST">
            @csrf
            
            <div class="heads">
                <h1 class="lgn">Booking Consultation App</h1>
            </div>
                <input type="email" placeholder="Email" name="email" required>
                <input type="password" placeholder="Password" name="password" required>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <a href="{{ route('register')}}">Dont have a account? Register here</a>
                <button type="submit">Login</button>
        </form>
    </div>

    
</body>
</html>
