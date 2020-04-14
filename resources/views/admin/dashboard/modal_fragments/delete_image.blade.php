<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <div class="text-center">
    <h4 class="modal-title" id="myModalLabel">Delete Image</h4>
  </div>
</div>
<div class="modal-body pad-20">
  <p>Are you sure want to delete this image?</p>
</div>
<div class="modal-footer">
  <form id="deleteForm" action="{{ route('delete_image', ['id' => $id, 'redirect' => TRUE]) }}" method="post">
    @method('delete')
    @csrf
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-danger">Delete</button>
  </form>
</div>