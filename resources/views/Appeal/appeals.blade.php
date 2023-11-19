@extends('layout')
@section('title','Appeals')
@section('content')
    <div class="container">
        <h1>Appeals</h1>
        @if($appeals->isEmpty())
            <p>No appeals available.</p>
        @else
            <div class="row">
                @foreach($appeals as $appeal)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Appeal №{{ $appeal->id }}</h5>
                                <p class="card-text">{{ $appeal->content }}</p>
                                <div class="d-grid gap-2">
                                    @if(auth()->user()->can('accept', $appeal))
                                        @if($appeal->is_accepted)
                                            <span class="text-success">Approval Accepted</span>
                                        @else
                                            <a href="{{ route('accept', ['id' => $appeal->id]) }}"
                                               class="btn btn-success">Accept</a>
                                        @endif
                                    @endif

                                    @if(auth()->user()->can('decline', $appeal))
                                        @if($appeal->is_declined)
                                            <span class="text-danger">Announcement Hidden</span>
                                        @else
                                            <a href="{{ route('decline', ['id' => $appeal->id]) }}"
                                               class="btn btn-danger">Decline</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
