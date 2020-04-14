<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <div class="text-center">
      <h4 class="modal-title" id="myModalLabel">Restore Post</h4>
    </div>
  </div>
  <div class="modal-body pad-20">
    <p>Are you sure want to restore this item?</p>
  </div>
  <div class="modal-footer">
    <form id="deleteForm" action="{{ route('post.restore', $id) }}" method="post">
        @csrf
        <button type="submit" class="btn btn-default">Restore</button>
    </form>
</div>