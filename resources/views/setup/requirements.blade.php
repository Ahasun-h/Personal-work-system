@extends('setup.setup_app')

<!-- Start:Title -->
@section('title','Welcome')
<!-- End:Title -->

<!-- Start:Content -->
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <p class="text-primary text-primary text-uppercase fw-bold m-0">Setup Check Requirements</p>
            </div>
            <div class="card-body">
                <ul class="m-0 p-0">
                    @foreach($results as $result)
                        <li  class="d-flex custom-list justify-content-between">
                            <span><i class='bx bx-chevron-right'></i> {{ $result['item'] }}</span>
                            @if($result['value'] == true)
                                <i class="bx bx-check text-white rounded-circle bg-success text-center check-icon"></i>
                            @else
                                <i class="bx bx-x text-white rounded-circle bg-danger text-center check-icon"></i>
                            @endif
                        </li>
                    @endforeach
                </ul>



                <a href="{{ route('setup.database') }}" class="btn btn-sm mt-2 {{ $success == true ? 'btn-danger disabled' : 'btn-primary' }}">
                   Continue
                </a>

            </div>
        </div>
    </div>
@endsection
<!-- End:Content -->
