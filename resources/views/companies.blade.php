@extends('layout')
@section('title', 'Companies')
@section('content')
<div class="container">
    <h1>All Companies</h1>
    <div class="row">
        @foreach($companies as $company)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Company №{{ $company->id }}</h5>
                    <p class="card-text">{{ $company->name }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
