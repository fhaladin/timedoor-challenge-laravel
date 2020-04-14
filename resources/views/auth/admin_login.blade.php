<html>
  <head>
    <title>Timedoor Challenge - Level 8 | Login</title>
    
    @include('admin.template.style')
    @include('admin.template.script')
    
    <!-- Javascript -->
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- Javascript End -->
  </head>
  
  <body id="login">
    <div class="login-box">
      <div class="login-box-head">
        <h1>Login</h1>
        <p>Please login to continue...</p>
      </div>
      <form action="{{ route('admin.login') }}" method="post">
        @csrf
        <div class="login-box-body">
            <div class="form-group">
              <input name="username" type="text" class="form-control" placeholder="Username" value="{{ old('username') }}">
              @error('username')
                <p class="mt-5 small text-danger">*{{ $message }}</p>
              @enderror
              @if (session('error'))
                <p class="mt-5 small text-danger">*{{ session('error') }}</p>
              @endif
            </div>
            <div class="form-group">
              <input name="password" type="password" class="form-control" placeholder="Password">
              @error('password')
                <p class="mt-5 small text-danger">*{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="login-box-footer">
            <div class="text-right">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
      </form>
    </div>
  </body>
  
</html>