@extends('layout')
@section('title', 'Fakebook')
@section('content')
<div class="row">
    
    @foreach($posts->chunk(4) as $chunk)
    <div class="row">
        @foreach($chunk as $post)
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('postdetails', $post->id) }}">
                            {{ $post->title }}
                        </a>
                    </h5>
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
                        <p>{{ $post->publish_date }}</p>
                    </p>
                    <div class="card-footer">
                    <p>
                        Likes: {{ $post->likes->where('pivot.is_deleted', false)->count() }}
                        <form method="POST" action="{{ route('like', $post->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-link">
                            @if (auth()->user()->likes->where('id', $post->id)->where('pivot.is_deleted', false)->count() > 0)
                                <i class="fas fa-thumbs-down"></i> Dislike
                            @else
                                <i class="fas fa-thumbs-up"></i> Like
                            @endif
                        </button>
                    </form>
                    </p>
                        <div class="float-left">
                            <p>Comments: {{ $post->comments->where('is_deleted', false)->count() }}<a href="{{ route('postdetails', $post->id) }}"><i class="fas fa-comments"></i></a></p>
                            
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

    $(document).ready(function() {
        $('.like-form').on('submit', function(event) {
            event.preventDefault();
            var $form = $(this);

            $.ajax({
                type: 'POST',
                url: $form.attr('action'),
                data: $form.serialize(),
                success: function(response) {
                    // Toggle the like/dislike button
                    var $likeButton = $form.find('.like-button');
                    if ($likeButton.text().trim() === 'Like') {
                        $likeButton.html('<i class="fas fa-thumbs-down"></i> Dislike');
                    } else {
                        $likeButton.html('<i class="fas fa-thumbs-up"></i> Like');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>
@endsection