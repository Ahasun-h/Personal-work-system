@extends('setup.setup_app')

<!-- Start:Title -->
@section('title','Setup Complete')
<!-- End:Title -->

<!-- Start:Content -->
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Setup Complete
            </div>
            <div class="card-body">
                <p>You completed the setup and now can use system! you are logged in.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    Go to the Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection
<!-- End:Content -->
