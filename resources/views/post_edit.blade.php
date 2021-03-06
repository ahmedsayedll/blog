@include ('layouts.app')
 <div class="container">
     @include ('partials.message')
    <form method="POST" action="/post/{{ $post->id }}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <div class="form-group">
            <label for="title">Post Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }} " placeholder="post title" required>
        </div>
        <div class="form-group">
            <label for="content">Post Content</label>
            <textarea class="form-control" name="content" id="content" cols="30" rows="10" placeholder="post content" required>{{ $post->content }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Post</button>
    </form>
</div>