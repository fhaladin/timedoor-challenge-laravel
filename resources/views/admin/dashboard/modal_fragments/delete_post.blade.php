<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <div class="text-center">
        <h4 class="modal-title" id="myModalLabel">Delete Post</h4>
    </div>
</div>
<div class="modal-body pad-20">
    @if (isset($id))
        <p>Are you sure want to delete this {{ (is_array($id)) ? 'checked' : '' }} item(s)?</p>
    @else
        <p>There is nothing checked item.</p>
    @endif
</div>
<div class="modal-footer">
    <form id="deleteForm" action="{{ route('post.destroy', $id ?? 0) }}" method="post">
        @method('delete')
        @csrf
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        @if (isset($id))
            <button type="submit" class="btn btn-danger">Delete</button>
        @endif
    </form>
</div>