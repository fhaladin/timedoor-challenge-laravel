<form action="{{ route('post.update', $post) }}" method="post" id="editForm" enctype="multipart/form-data">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Item</h4>
    </div>
    @method('put')
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" id="editName" class="form-control" value="{{ $post->name }}">
        </div>
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" id="editTitle" class="form-control" value="{{ $post->title }}">
        </div>
        <div class="form-group">
            <label>Body</label>
            <textarea rows="5" name="body" id="editBody" class="form-control">{{ $post->body }}</textarea>
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                @if (!empty($post->image))
                    <img class="img-responsive img-post" src="{{ asset('storage/post/' . $post->image) }}" alt="">
                @else
                    <img class="img-responsive img-post" src="http://via.placeholder.com/500x500" alt="image">
                @endif
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