<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/simplebar/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/vendors/simplebar.css')}} ">
    <!-- Main styles for this application-->
    <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
    <link href="css/examples.css" rel="stylesheet">

    <style>
        .check-icon{
            width: 20px;
            height: 20px;
            padding: 0px;
            line-height: 20px !important;
        }
    </style>

    @stack('css')

    <!-- Box-icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        // Shared ID
        gtag('config', 'UA-118965717-3');
        // Bootstrap ID
        gtag('config', 'UA-118965717-5');
    </script>
</head>
<body>
    <div class="min-vh-100 d-flex flex-row align-items-center">
        <div class="container-fluid mx-4">
            <div class="d-flex justify-content-center align-items-center" >
                <div class="col-md-4 px-2">
                    <div class="card-group d-block d-md-flex row">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stack('script')

</body>
</html>
