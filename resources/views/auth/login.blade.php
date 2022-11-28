@extends('auth.layouts.app')

<!-- Title -->
@section('title','Login')

<!-- Page Image -->
@section('auth_image')
    <img class="mx-auto d-block" src="{{ asset('dashboard/image/login_image.jpg') }}" style="width: 80vh"/>
@endsection

@section('content')
<div class="container">
    <h3 class="text-primary text-primary text-uppercase fw-bold">{{ __('Login') }}</h3>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="row mb-2">
            <label for="email" class="col-12 col-form-label text-start">{{ __('Email Address') }}</label>
            <div class="col-12">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row mb-2">
            <label for="password" class="col-12 col-form-label text-start">{{ __('Password') }}</label>
            <div class="col-md-12">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
            <div class="col-7">
                @if (Route::has('password.request'))
                    <a class="btn btn-link text-end d-block" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </div>
        <div class="row mb-0">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
