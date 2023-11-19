@extends('layout')
@section('title', 'Post Details')
@section('content')
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">{{ $post->title }}</h2>
            <p class="card-text">{{ $post->content }}</p>
            <p class="card-text"><small class="text-muted">Publish Date: {{ $post->publish_date }}</small></p>
        </div>
    </div>
    <h3>Comments</h3>
    <ul>
        @foreach ($post->comments as $comment)
            <li>{{ $comment->user->name }}: {{ $comment->content }}
                @if (auth()->id() === $comment->user_id)
                    <a href="{{ route('comments.destroy', ['id' => $comment->id]) }}">
                        <i class="fas fa-trash"></i>
                    </a>
                @endif
            </li>

        @endforeach
    </ul>

    <form method="POST" action="{{ route('comments.store', $post->id) }}">
        @csrf
        <div class="form-group">
            <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="3" placeholder="Add your comment"></textarea>
            @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit Comment</button>
    </form>

@endsection
