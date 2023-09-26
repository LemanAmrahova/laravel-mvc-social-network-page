@extends('layout')
@section('title', isset($post) ? 'Edit Post' : 'Add Post')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ isset($post) ? 'Edit Post' : 'Add Post' }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ isset($post) ? route('editpost', $post->id) : route('addpost') }}">
                            @csrf
                            @if(isset($post))
                                @method('PUT') 
                            @endif

                            @if(isset($post))
                                <input type="hidden" name="id" value="{{ $post->id }}">
                            @endif


                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ isset($post) ? $post->title : old('title') }}" >
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="4" >{{ isset($post) ? $post->content : old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="publish_date" class="form-label">Publish Date</label>
                                <input type="date" class="form-control @error('publish_date') is-invalid @enderror" id="publish_date" name="publish_date" value="{{ isset($post) ? $post->publish_date : old('publish_date') }}">
                                @error('publish_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ isset($post) ? 'Update Post' : 'Add Post' }}</button>
                                <a href="{{ route('myposts') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection