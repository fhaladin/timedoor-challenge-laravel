<html>
  <head>
    <title>Timedoor Challenge - Level 8 | Email Verify</title>
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/tmdrPreset.css') }}">
    <!-- CSS End -->
    
    <!-- Javascript -->
    <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <!-- Javascript End -->
  </head>
  
  <body id="login">
    <div class="box login-box text-center">
      <div class="login-box-head">
        <h1>Verify Your Email Address</h1>
      </div>
      <div class="login-box-body">
        <p>Before proceeding,</p>
        <p>please check your email for a verification link.</p>
        <p>If you did not receive the email,</p>
    </div>
    <div class="login-box-footer">
        <div class="text-center">
          <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Click here to request another link</button>
            or
            <a href="#" class="btn btn-default" onclick="$('#logout-form').submit()">Back to Home</a>
          </form>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </div>
      </div>
    </div>
  </body>
  
</html>