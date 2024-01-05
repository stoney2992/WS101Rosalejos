<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MathQuest</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{url('/css/style.css')}}">
        
    </head>

    <body>
        <!------start of sidebar------->
        <div class="container-dashboard">
            <div class="sidebar">
                <img src="{{url('/photos/logoImage.png')}}" alt="images" >
                

                <div class="db-image">
                    <img src="{{url('/photos/class.png')}}" alt="images" >
                </div>
                <div class="game-image">
                    <img src="{{url('/photos/pupils.png')}}" alt="images" >
                </div>
                <div class="activity-image">
                    <img src="{{url('/photos/activity.png')}}" alt="images" >
                </div>
                <div class="rewards-image">
                    <img src="{{url('/photos/prize.png')}}" alt="images" >
                </div>


                <ul>
                    <h1>MathQuest</h1>
                    <li><a href='dashboard'>Classes</a></li>
                    <li><a href='pupils'>Pupils</a></li>
                    <li><a href='activity'>Activities</a></li>
                    <li><a href='reward'>Rewards</a></li>
                </ul>
            </div>
            <div class="hamburger-menu">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
             </div>
             <!------end of sidebar------->


              <!------start of search bar------->

            <div class="search-bar">
                <form action="">
                    <input type="text" placeholder="Search " name="search"> 
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
               <!------end of search bar------->
            
               <!----start messages , notification and profile-------->
            <div class="message">
               <p class="msg-btn"> <i class="fa fa-solid fa-envelope fa-2x"></i> </p>
               <p class="nt-btn"> <i class="fa fa-solid fa-bell fa-2x"></i> </p>
               <img src="{{url('/photos/boyhead.png')}}" alt="profile pic" width="30px" height="30px">
               <h1> Juan Dela Cruz </h1>
            </div>
               <!----end messages , notification and profile-------->

              <!-----activities-->
                <div class="activities-content">
                    <button> <i class="fa-solid fa-circle-plus"></i> Add </button>

                </div>
              
              <!-----end activities-->

        </div>
        
    </body>
</html>
