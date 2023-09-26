@extends('layout')
@section('title','Add Company')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Company</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('addcompany') }}">
                        @csrf
                        <div class="mb-3">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>

                        <button type="submit" class="btn btn-primary">Add Company</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
