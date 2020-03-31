<html>
  <head>
    <title>Timedoor Challenge - Level 8 | Register</title>
    
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
        <h1 class="mb-5">Register</h1>
        <p class="text-lgray">Please fill the information below...</p>
      </div>
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="login-box-body">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}">
            @error('name')
              <p class="mt-5 small text-danger">*{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="E-mail" name="email" value="{{ old('email') }}">
            @error('email')
              <p class="mt-5 small text-danger">*{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name="password">
            @error('password')
              <p class="mt-5 small text-danger">*{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div class="login-box-footer">
          <div class="text-right">
            <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-primary">Confirm</button>
          </div>
        </div>
      </form>
    </div>
  </body>
  
</html>