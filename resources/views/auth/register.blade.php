@extends('auth.layouts.app')

<!-- Title -->
@section('title','Register')

<!-- Page Image -->
@section('auth_image')
    <img class="mx-auto d-block" src="{{ asset('dashboard/image/login_image.jpg') }}" style="width: 80vh"/>
@endsection

@section('content')
<div class="container">
    <h3 class="text-primary text-primary text-uppercase fw-bold">{{ __('Register') }}</h3>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="row mb-3">
            <label for="name" class="col-12 col-form-label">{{ __('Name') }}</label>
            <div class="col-12">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-12 col-form-label">{{ __('Email Address') }}</label>
            <div class="col-12">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="password" class="col-12 col-form-label">{{ __('Password') }}</label>
            <div class="col-12">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="password-confirm" class="col-12 col-form-label">{{ __('Confirm Password') }}</label>
            <div class="col-12">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-5">
                <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                </button>
            </div>
            <div class="col-7">
                @if (Route::has('password.request'))
                    <a class="btn btn-link text-end d-block" href="{{ route('login') }}">
                        {{ __('Back to Login') }}
                    </a>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection
