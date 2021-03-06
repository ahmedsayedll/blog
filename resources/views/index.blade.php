
@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @include ('partials.message')

    <h1 class="text-center">welcome to my blog</h1>

    <div class="container">
        @include ('partials.errors')        
        @foreach($posts as $post)
            <div class="blog-post">
                <h2 class="blog-post-title"><a href="/post/{{ $post->id }}">{{ $post->title }}</a></h2>
                @if(Auth::id() == $post->user->id)
                    <a href="/post/{{ $post->id }}/edit" class="btn btn-dark float-left">edit</a>
                    <form action="/post/{{ $post->id }}" method="POST" class="float-left ml-2">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger" type="submit">delete</button>
                    </form> 
                    <div class="clearfix"></div>
                @endif
                <p class="blog-post-meta">{{ $post->created_at->diffForHumans() }} by <a href="{{ route('author', $post->user->id) }}">{{ $post->user->name }}</a></p>
                <p>{{ $post->content }}</p>
                <div class="likesys">
                    <form action="like/Post/up" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="likeable_id" value="{{ $post->id }}">
                        <input type="submit" value="up">
                    </form>
                    @if( count($post->likes)>0 )
                        {{ count($post->likes) }}
                    @else
                        {{ 0 }}
                    @endif
                    <form action="like/Post/down" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('Delete') }}
                        <input type="hidden" name="likeable_id" value="{{ $post->id }}">
                        <input type="submit" value="down">
                    </form>
                </div>
                <ul>
                    @foreach($post->comments->reverse() as $comment)
                        <li>
                            <strong><a href="{{ route('author', $comment->user->id) }}">{{ $comment->user->name }}</a></strong>
                            <u>({{ $comment->created_at->diffForHumans() }})</u>
                            {{ $comment->content }}
                            <div class="likesys">
                                <form action="like/Comment/up" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="likeable_id" value="{{ $comment->id }}">
                                    <input type="submit" value="up">
                                </form>
                                @if( count($comment->likes)>0 )
                                    {{ count($comment->likes) }}
                                @else
                                    {{ 0 }}
                                @endif
                                <form action="like/Comment/down" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('Delete') }}
                                    <input type="hidden" name="likeable_id" value="{{ $comment->id }}">
                                    <input type="submit" value="down">
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <form method="POST" action="post/{{ $post->id }}/comment">
                {{ csrf_field() }}
                {{-- <input type="hidden" name="post_id" value="{{ $post->id }}"> this term is wrong can cause injection --}}
                <div class="form-group">
                    <label for="content">Comment Content</label>
                    <textarea class="form-control" name="content" id="content" cols="30" rows="3" placeholder="comment content" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Comment</button>
            </form>
            <hr class="mb-5">
        @endforeach
        <div class="text-center">{{ $posts->links() }}</div>
    </div>
@endsection