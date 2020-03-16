<html>
  <head>
    <title>Timedoor Challenge - Level 8</title>
    @include('template.style')
    @include('template.script')
  </head>

  <body class="bg-lgray">
    <header>
      @include('template.header')
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
      @include('template.footer')
    </footer>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Edit Item</h4>
          </div>
          <form action="{{ route('post.update', 0) }}" method="post" id="editForm" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" id="editName" class="form-control" value="">
              </div>
              <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" id="editTitle" class="form-control" value="">
              </div>
              <div class="form-group">
                <label>Body</label>
                <textarea rows="5" name="body" id="editBody" class="form-control"></textarea>
              </div>
              <div class="form-group row">
                <div class="col-md-4">
                  <img class="img-responsive" id="editImage" alt="" src="https://via.placeholder.com/500x500">
                </div>
                <div class="col-md-8 pl-0">
                  <label>Choose image from your computer :</label>
                  <div class="input-group">
                    <input type="text" class="form-control upload-form" value="No file chosen" readonly>
                    <span class="input-group-btn">
                      <span class="btn btn-default btn-file">
                        <i class="fa fa-folder-open"></i>&nbsp;Browse <input type="file" name="image">
                      </span>
                    </span>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input name="delete_image" type="checkbox">Delete image
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Delete Data</h4>
          </div>
          <form id="deleteForm" action="{{ route('post.destroy', 0) }}" method="post">
            @method('delete')
            @csrf
            <div class="modal-body pad-20">
              <p>Are you sure want to delete this item?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Warning Error</h4>
          </div>
          <div class="modal-body pad-20">
            <p>The passwords you entered do not match. Please try again.</p>
          </div>
          <div class="modal-footer">
            <form class="form-password-check form-inline" action="{{ route('password_check') }}" method="post">
              @csrf
              <div class="form-group mx-sm-3 mb-2">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" class="form-control password" name="password" id="inputPassword" placeholder="Password">
              </div>
              <button type="submit" name="edit" value="edit" class="btn btn-default mb-2"><i class="fa fa-pencil p-3"></i></button>
              <button type="submit" name="delete" value="delete" class="btn btn-danger mb-2"><i class="fa fa-trash p-3"></i></button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      // INPUT TYPE FILE
      $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
      });

      $(document).ready( function() {
        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
            input.val(log);
          } else {
            if( log ) alert(log);
          }
        });
      });

      $('.form-password-check').ajaxForm({
        success: function(response) {
          $('.password').val('');
          $('#errorModal').modal('hide');  
         
          setTimeout(function(){ 
            if (response.error) {
              $('#errorModal').modal();     
            }else{
              if(response.edit) {
                $('#editName').val(response.name);
                $('#editTitle').val(response.title);
                $('#editBody').html(response.body);
                $('#editImage').attr('src', response.image);
                $('#editModal').modal();
              } else {
                $('#deleteModal').modal();
              }
            }
          }, 500);   
        }
      });
    </script>
  </body>
</html>