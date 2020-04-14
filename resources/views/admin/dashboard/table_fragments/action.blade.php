@if (empty($post->deleted_at))
    <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-danger" rel="tooltip" title="Delete" onclick="modal({{ $post->id  }}, 'delete_post')"><i class="fa fa-trash"></i></a>
@else
    <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-default" rel="tooltip" title="Recover" onclick="modal({{ $post->id }}, 'restore_post')"><i class="fa fa-repeat"></i></a>
@endif