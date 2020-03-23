<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title" id="myModalLabel">Warning Error</h4>
</div>
<div class="modal-body pad-20">
    <p>{{ $message }}</p>
</div>
<div class="modal-footer">
    @if (isset($post->password))
        <form class="form-password-check form-inline" action="{{ route('password_check', ['id' => $post]) }}" method="post">
            @csrf
            <div class="form-group mx-sm-3 mb-2">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" class="form-control password" name="password" id="inputPassword" placeholder="Password">
            </div>
            @if ($action === 'edit')
                <button type="submit" name="edit" value="edit" class="btn btn-default mb-2" onclick="password_check()"><i class="fa fa-pencil p-3"></i></button>
            @else
                <button type="submit" name="delete" value="delete" class="btn btn-danger mb-2" onclick="password_check()"><i class="fa fa-trash p-3"></i></button>
            @endif
        </form>
    @else
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    @endif
</div>