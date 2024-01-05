<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MathQuest</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{url('/css/style.css')}}">
        
    </head>

    <body>
        <div class="container-heads">
        <form action="{{ route('login_action') }}" method="post">
           
                <div class="heads">
                    <h1 class="lgn">MathQuest</h1>
                </div>

                <img src="{{url('/photos/loginImg.jpg')}}" alt="images" >
                
        <!------Login start ----->
                <div class="container-login">
                    <form>

                        <label for="uname" id="user"><b></b></label>
                        <input type="email" id="email" placeholder="Email" name="email" required>

                        <label for="psw" id="passw"><b></b></label>
                        <input type="password" id="password" placeholder="Password" name="psw" required>

                        <button id="btn1" type="submit">Login</button>
                    </form>
                </div>
        <!------Login end ----->                    
             </form>
        </div>
        
    </body>
</html>
