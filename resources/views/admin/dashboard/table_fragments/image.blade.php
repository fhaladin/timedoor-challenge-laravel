@if (!empty($post->image) && empty($post->deleted_at))
    <img class="img-prev" src="{{ asset('storage/post/' . $post->image) }}" alt="">
    <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-danger ml-10 btn-img" rel="tooltip" title="Delete Image" onclick="modal({{ $post->id }}, 'delete_image')"><i class="fa fa-trash"></i></a>
@else
    -
@endif