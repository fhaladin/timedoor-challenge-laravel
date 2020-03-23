<html>
  <head>
    <title>Timedoor Challenge - Level 8</title>
    @include('user.template.style')
    @include('user.template.script')
  </head>

  <body class="bg-lgray">
    <header>
      @include('user.template.header')
    </header>
    <main>
      <div class="section">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-md-offset-3 bg-white p-30 box">
              <div class="text-center">
                <h1 class="text-green mb-30"><b>Level 8 Challenge</b></h1>
              </div>
              @if(session('errors'))
                @if ($errors->any())
                  @foreach ($errors->all() as $error)
                    <p class="small text-danger text-center">*{{ $error }}</p>
                  @endforeach
                  <br>
                @endif
              @endif
              @yield('content')
            </div>
          </div>
        </div>
      </div>
    </main>
    
    <footer>
      @include('user.template.footer')
    </footer>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      $(document).ready( function() {
        select_file();
      });

      // INPUT TYPE FILE
      function select_file(){
        $(document).on('change', '.btn-file :file', function() {
          var input = $(this),
              numFiles = input.get(0).files ? input.get(0).files.length : 1,
              label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
          input.trigger('fileselect', [numFiles, label]);
        });

        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
            input.val(log);
          } else {
            if( log ) alert(log);
          }
        });
      }
      
      function password_check(){
        $('.form-password-check').ajaxForm({
          success: function (response) {
            $('#modal').modal();
            $('.modal-content').empty().html(response);
            select_file();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(thrownError);
          }
        });
      }
    </script>
  </body>
</html>