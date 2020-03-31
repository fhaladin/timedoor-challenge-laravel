<html>
  <head>
    <title>Timedoor Challenge - Level 8 | Register Confirm</title>
    
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
    <div class="box login-box">
      <div class="login-box-head">
        <h1>Register</h1>
      </div>
      <div class="login-box-body">
        <table class="table table-no-border">
          <tbody>
            <tr>
              <th>Name</th>
              <td>{{ session('register')['name'] }}</td>
            </tr>
            <tr>
              <th>E-mail</th>
              <td>{{ session('register')['email'] }}</td>
            </tr>
            <tr>
              <th>Password</th>
              <td>{{ session('register')['password'] }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="login-box-footer">
        <div class="text-right">
          <form action="{{ route('register') }}" method="post">
            @csrf
            <button type="submit" name="step2" value="step2" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </body>
  
</html>