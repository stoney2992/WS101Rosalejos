<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>MathQuest</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}">
</head>
<body>
    <div class="forgotPassword">
        <!-- errors -->
        <div class="msg-error">
            @if($errors->any())
                <div class="col-12">
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                    @endforeach    
                </div>
            @endif    

            @if(session()->has('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
            @endif

            @if(session()->has('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @endif
        </div>
        <!-- end errors -->
        <form action="{{ route('reset.password.post') }}" method="POST">
            @csrf
            <input type="text" hidden name="token" value="{{$token}}">
            
                <div class="email">
                    <input type="email" name="email" placeholder="Email Address" >
                </div>
                <div class="email">
                    <input type="password" name="password" placeholder="enter new password" >
                </div>
                <div class="email">
                    <input type="password" name="password_confirmation" placeholder="confirm password" >
                </div>
                <button type="submit" class="email-btn">Submit</button>
        </form>
            
    </div>
    <script src="{{ url('/js/dashboard.js') }}"></script>
</body>
</html>
