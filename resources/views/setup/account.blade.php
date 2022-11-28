@extends('setup.setup_app')

<!-- Start:Title -->
@section('title','Account Setup')
<!-- End:Title -->

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
        .ck-editor__editable[role="textbox"] {
            min-height: 150px;
        }
    </style>
@endpush

<!-- Start:Content -->
@section('content')
    <div class="container">
        <div class="card">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-primary text-primary text-uppercase fw-bold m-0">Account Setup</h5>
                </div>
                <div class="card-body">

                    <p>Register Account</p>

                    <!-- Start:Alert -->
                    @include('partials.alert')
                    <!-- End:Alert -->

                    <form action="{{ route('setup.save-account') }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="name">
                                Name
                            </label>
                            <input type="text" name="name" id="name"
                                   class="form-control"
                                   placeholder="username" aria-label="username"
                                   value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <p class="invalid-feedback" role="alert">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="email">
                                Email
                            </label>
                            <input type="email" name="email" id="email"
                                   class="form-control"
                                   placeholder="email" aria-label="email"
                                   value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <p class="invalid-feedback" role="alert">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="password">
                                password
                            </label>
                            <input type="password" name="password" id="password"
                                   class="form-control"
                                   value="{{ old('password') }}" aria-label="password">
                            @if ($errors->has('password'))
                                <p class="invalid-feedback" role="alert">
                                    {{ $errors->first('password') }}
                                </p>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation">
                                Confirmed Password
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control"
                                   value="{{ old('password_confirmation') }}" aria-label="password_confirmed">
                            @if ($errors->has('password_confirmation'))
                                <p class="invalid-feedback" role="alert">
                                    {{ $errors->first('password_confirmation') }}
                                </p>
                            @endif
                        </div>

                        <div class="my-3">
                            <label for="User Avarat">
                               User Avatar
                            </label>
                            <input type="file" class="form-control dropify" data-default-file="{{ asset('dashboard/image/user.png') }}" name="user_avatar" id="user_avatar">
                            @error('user_avatar')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>



                        <button type="submit" class="btn btn-primary">Create</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
<!-- End:Content -->

@push('script')

    <!-- Ajax CDN -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
            integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
            crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>
@endpush
