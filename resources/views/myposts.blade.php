@extends('layout')
@section('title', 'My Posts')
@section('content')
<div class="container">
    <h2>My Posts</h2>
    <div class="row">
        @foreach($posts as $post)
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">
                        @if (strlen($post->content) > 25)
                            <span id="postContent{{ $post->id }}" class="show-more-content">
                                {{ substr($post->content, 0, 25) }}
                            </span>
                            <span id="showMore{{ $post->id }}" style="display: none;">
                                {{ substr($post->content, 25) }}
                            </span>
                            <a href="#" onclick="togglePostContent({{ $post->id }}); return false;" id="showMoreLink{{ $post->id }}">Show more</a>
                            <a href="#" onclick="togglePostContent({{ $post->id }}); return false;" style="display: none;" id="showLessLink{{ $post->id }}">Show less</a>
                        @else
                            {{ $post->content }}
                        @endif
                    </p>
                    <p class="publish-date">{{ $post->publish_date }}</p>
                    <div class="card-footer">
                        <a href="{{ route('editpost', ['id' => $post->id]) }}"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('delete', ['id' => $post->id]) }}"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script>
    function togglePostContent(postId) {
        var showMoreContent = document.getElementById("showMore" + postId);
        var showMoreLink = document.getElementById("showMoreLink" + postId);
        var showLessLink = document.getElementById("showLessLink" + postId);

        if (showMoreContent.style.display === "none" || showMoreContent.style.display === "") {
            showMoreContent.style.display = "inline";
            showMoreLink.style.display = "none";
            showLessLink.style.display = "inline";
        } else {
            showMoreContent.style.display = "none";
            showMoreLink.style.display = "inline";
            showLessLink.style.display = "none";
        }
    }
</script>
@endsection
