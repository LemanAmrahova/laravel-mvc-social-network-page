@extends('layout')
@section('title','Announcements')
@section('content')

<div class="container">
    <h1>Announcements</h1>
    <div class="row">

        <div class="text-end">
            <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
        </div>
        @foreach($announcements as $announcement)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $announcement->title }}</h5>
                    <p class="card-text">User: {{ $announcement->company->user->name }}</p>
                    <p class="card-text">Company: {{ $announcement->company->name }}</p>
                    @if (auth()->user()->id != $announcement->company->user->user_id)
                        <form method="POST" action="{{ route('addappeal') }}">
                            @csrf
                            <input type="hidden" name="announcement_id" value="{{ $announcement->id }}">
                            <button type="submit" class="btn btn-primary">Appeal</button>
                        </form>
                    @endif
                    @isset($announcement->appeals)
                    @if ($announcement->appeals->count() > 0)
                    <a href="{{ route('appeals', ['announcement_id' => $announcement->id]) }}" class="btn btn-success">
                        <i class="bi bi-list-ul"></i> View Appeals
                    </a>
                    @endif
                    @endisset
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection

