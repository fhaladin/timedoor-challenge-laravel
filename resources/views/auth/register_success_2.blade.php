<html>
  <head>
    <title>Timedoor Challenge - Level 8 | Register Success</title>
    
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/tmdrPreset.css">
    <!-- CSS End -->
    
    <!-- Javascript -->
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- Javascript End -->
  </head>
  
  <body id="login">
    <div class="box login-box text-center">
      <div class="login-box-head">
        <h1>Successfully Registered</h1>
      </div>
      <div class="login-box-body">
        <p>Thank you for your membership register.<br/>
          We send confirmation e-mail to you. Please complete the registration by clicking the confirmation URL.</p>
      </div>
      <div class="login-box-footer">
        <div class="text-center">
          <a href="{{ route('post.index') }}" class="btn btn-primary">Back to Home</a>
        </div>
      </div>
    </div>
  </body>
  
</html>