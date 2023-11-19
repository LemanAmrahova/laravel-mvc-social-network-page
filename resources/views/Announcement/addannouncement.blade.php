@extends('layout')
@section('title','Add Announcement')
@section('content')
    <div class="container">
        <h1>Add Announcement</h1>
        <form method="POST" action="{{ route('announcements.store') }}">
            @csrf

            <div class="mb-3">
                <label for="company_id" class="form-label">Select Company</label>
                <select class="form-select" id="company_id" name="company_id">
                    <option value="">Select a Company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Announcement Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title">
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
