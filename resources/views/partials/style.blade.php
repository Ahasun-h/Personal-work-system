<!-- Vendors styles-->
<link rel="stylesheet" href="{{ asset('dashboard/vendors/simplebar/css/simplebar.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/css/vendors/simplebar.css') }}">
<!-- Main styles for this application-->
<link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
<!-- We use those styles to show code examples, you should remove them in your application.-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
<link href="{{ asset('dashboard/css/examples.css') }}" rel="stylesheet">

<!-- Linearicons -->
<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">

<!-- boxicons -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<!-- Toastr CSS -->
<link rel="stylesheet" href="{{ asset('dashboard/vendors/toastr/toastr.css') }}">

<!-- Custom CSS -->
<link rel="stylesheet" href="{{ asset('dashboard/css/custom.css') }}">

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

@stack('style')
