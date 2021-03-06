@extends('user.template.master')
@section('content')
  <form action="{{ route('post.store') }}" id="storeForm" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label>Name</label>
      <input type="text" name="name" class="form-control" value="{{ (!Auth::user()) ? ((old('_method') != 'put') ? old('name') : '') : Auth::user()->name }}">
    </div>
    <div class="form-group">
      <label>Title</label>
      <input type="text" name="title" class="form-control" value="{{ (old('_method') != 'put') ? old('title') : '' }}">
    </div>
    <div class="form-group">
      <label>Body</label>
      <textarea rows="5" name="body" class="form-control">{{ (old('_method') != 'put') ? old('body') : '' }}</textarea>
    </div>
    <div class="form-group">
      <label>Choose image from your computer :</label>
      <div class="input-group">
        <input type="text" class="form-control upload-form" value="No file chosen" readonly>
        <span class="input-group-btn">
          <span class="btn btn-default btn-file">
            <i class="fa fa-folder-open"></i>&nbsp;Browse <input name="image" type="file" name="image">
          </span>
        </span>
      </div>
    </div>
    @if (!Auth::check())
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
      </div>
    @endif
    <div class="text-center mt-30 mb-30">
      <button class="btn btn-primary">Submit</button>
    </div>
  </form>
  <hr>
  @foreach ($posts as $post)
    @php
      $condition = (Auth::check()) ? Auth::user()->id == $post->user_id : !isset($post->user_id);
    @endphp
    <div class="post">
      <div class="clearfix">
        <div class="pull-left">
          <h2 class="mb-5 text-green"><b>{{ $post->title }}</b></h2>
        </div>
        <div class="pull-right text-right">
          <p class="text-lgray">{{ date('Y-m-d', strtotime($post->created_at)) }}<br/><span class="small">{{ date('H:i', strtotime($post->created_at)) }}</span></p>
        </div>
      </div>
      <h4 class="mb-20">{{ $post->name ?? 'No Name' }} <span class="text-id">{{ (isset($post->user_id)) ? '[ID:' . $post->user_id . ']' : null }}</span></h4>
      <p style="white-space: pre-line">{{ $post->body }}</p>
      <br>
      <div class="form-group row">
        <div class="col-md-5">
          @if (!empty($post->image))
            <img class="img-responsive img-post" src="{{ asset('storage/post/' . $post->image) }}" alt="">
          @else
            <img class="img-responsive img-post" src="http://via.placeholder.com/500x500" alt="image">
          @endif
        </div>
        @if ($condition)
          <form class="col-md-7 form-password-check form-inline mt-50" action="{{ route('password_check', ['id' => $post, 'user_id' => $post->user_id ?? 0]) }}" method="post">
            @csrf
            @if (!Auth::check())
              <div class="form-group mx-sm-3 mb-2">
                <label for="inputPassword{{ $post->id }}" class="sr-only">Password</label>
                <input type="password" class="form-control password" name="password" id="inputPassword{{ $post->id }}" placeholder="Password">
                <input type="hidden" name="id" value="{{ $post->id }}">
              </div>
            @endif
            <button type="submit" name="edit" value="edit" class="btn btn-default mb-2" onclick="password_check()"><i class="fa fa-pencil p-3"></i></button>
            <button type="submit" name="delete" value="delete" class="btn btn-danger mb-2" onclick="password_check()"><i class="fa fa-trash p-3"></i></button>
          </form>
        @endif
      </div>
    </div>
  @endforeach
  <div class="text-center mt-30">
    {{ $posts->links() }}
  </div>
@endsection