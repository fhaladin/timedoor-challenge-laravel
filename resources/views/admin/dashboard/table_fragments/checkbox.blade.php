@if (empty($post->deleted_at))
    <input type="checkbox" class="checkbox-post" value="{{ $post->id }}" onclick="check_checked()">
@endif