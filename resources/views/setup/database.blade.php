@extends('setup.setup_app')

<!-- Start:Title -->
@section('title','Database Setup')
<!-- End:Title -->

<!-- Start:Content -->
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="text-primary text-primary text-uppercase fw-bold m-0">Database Configuration</h5>
            </div>
            <div class="card-body">

                <p>If you already filled the database in your .env file the input fields should be pre-filled. Otherwise, fill the fields with the corresponding information for your database.</p>
                <!-- Start:Alert -->
                @include('partials.alert')
                <!-- End:Alert -->
                <form action="{{ route('setup.save-database') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="db_host">
                            Database Host
                        </label>
                        <input type="text" name="db_host" id="db_host" required
                               class="form-control{{ $errors->has('db_host') ? ' is-invalid' : '' }}"
                               placeholder="localhost" value="{{ old('db_host') ?: env('DB_HOST', 'localhost') }}">
                        @if ($errors->has('db_host'))
                            <p class="invalid-feedback" role="alert">
                                {{ $errors->first('db_host') }}
                            </p>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="db_port">
                            Database Port
                        </label>
                        <input type="number" name="db_port" id="db_port" required
                               class="form-control{{ $errors->has('db_port') ? ' is-invalid' : '' }}"
                               placeholder="3306" value="{{ old('db_port') ?: env('DB_PORT', 3306) }}">
                        @if ($errors->has('db_port'))
                            <p class="invalid-feedback" role="alert">
                                {{ $errors->first('db_port') }}
                            </p>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="db_name">
                            Database Name
                        </label>
                        <input type="text" name="db_name" id="db_name" required
                               class="form-control{{ $errors->has('db_name') ? ' is-invalid' : '' }}"
                               value="{{ old('db_name') ?: env('DB_DATABASE') }}">
                        @if ($errors->has('db_name'))
                            <p class="invalid-feedback" role="alert">
                                {{ $errors->first('db_name') }}
                            </p>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="db_user">
                            Database User
                        </label>
                        <input type="text" name="db_user" id="db_user" required
                               class="form-control{{ $errors->has('db_user') ? ' is-invalid' : '' }}"
                               value="{{ old('db_user') ?: env('DB_USERNAME') }}">
                        @if ($errors->has('db_user'))
                            <p class="invalid-feedback" role="alert">
                                {{ $errors->first('db_user') }}
                            </p>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="db_password">
                            Database Password
                        </label>
                        <input type="password" name="db_password" id="db_password"
                               class="form-control{{ $errors->has('db_password') ? ' is-invalid' : '' }}"
                               value="{{ old('db_password') ?: env('DB_PASSWORD') }}">
                        @if ($errors->has('db_password'))
                            <p class="invalid-feedback" role="alert">
                                {{ $errors->first('db_password') }}
                            </p>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">
                        @if($errors->any())
                         Try Again
                        @else
                           Database Configure
                        @endif
                    </button>
                    <p class="small text-muted mt-3 mb-0">Saving the database configuration and processing it for using the app may take a few seconds, please be patient.</p>
                </form>
            </div>
        </div>
    </div>
@endsection
<!-- End:Content -->
