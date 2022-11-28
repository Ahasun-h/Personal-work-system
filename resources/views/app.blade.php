<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Dashboard - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>
        @yield('title')
    </title>
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('dashboard/image/fav-icon.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('dashboard/image/fav-icon.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('dashboard/image/fav-icon.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('dashboard/image/fav-icon.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('dashboard/image/fav-icon.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('dashboard/image/fav-icon.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('dashboard/image/fav-icon.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('dashboard/image/fav-icon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('dashboard/image/fav-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('dashboard/image/fav-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('dashboard/image/fav-icon.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('dashboard/image/fav-icon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('dashboard/image/fav-icon.png') }}">
    <link rel="manifest" href="{{ asset('dashboard/image/fav-icon.png') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('dashboard/image/fav-icon.png') }}">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Style -->
    @include('partials.style')

</head>
<body>
<!-- Start:Sidebar -->
@include('partials.sidebar')
<!-- End:Sidebar -->
<div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <!-- Start:Header -->
    @include('partials.header')
    <!-- End:Header -->
    <div class="body flex-grow-1 px-3">
        @yield('content')
    </div>
    <footer class="footer">
        <div><a href="https://coreui.io">CoreUI </a><a href="https://coreui.io">Bootstrap Admin Template</a> © 2022 creativeLabs.</div>
        <div class="ms-auto">Powered by&nbsp;<a href="https://coreui.io/docs/">Dashboard UI Components</a></div>
    </footer>
</div>

@include('partials.script')

</body>
</html>
