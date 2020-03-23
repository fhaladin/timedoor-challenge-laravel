<form id="deleteForm" action="{{ route('post.destroy', $post) }}" method="post">
    @method('delete')
    @csrf
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Data</h4>
    </div>
    <div class="modal-body pad-20">
        <p>Are you sure want to delete this item?</p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Delete</button>
    </div>
</form>