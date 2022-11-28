@extends('setup.setup_app')

<!-- Start:Title -->
@section('title','Welcome')
<!-- End:Title -->

<!-- Start:Content -->
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
               <h5 class="text-primary text-primary text-uppercase fw-bold m-0">Setup Welcome</h5>
            </div>
            <div class="card-body">
                <p class="fw-bold">In the following steps you will set up to ready to use</p>
                <ol>
                    <li>Check All requirements are met. </li>
                    <li>Setup database and check if the connection is sucessfull.</li>
                    <li>create your account.</li>
                    <li>Setup system setting.</li>
                </ol>
                <a href="{{ route('setup.requirements') }}" class="btn btn-primary">
                    Setup Check Requirements
                </a>
            </div>
        </div>
    </div>
@endsection
<!-- End:Content -->
