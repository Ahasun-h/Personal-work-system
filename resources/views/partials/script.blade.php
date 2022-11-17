<!-- Dashboard and necessary plugins-->
<script src="{{ asset('dashboard/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
<script src="{{ asset('dashboard/vendors/simplebar/js/simplebar.min.js') }}"></script>
<!-- Plugins and scripts required by this view-->
<script src="{{ asset('dashboard/vendors/chart.js/js/chart.min.js') }}"></script>
<script src="{{ asset('dashboard/vendors/@coreui/chartjs/js/coreui-chartjs.js') }}"></script>
<script src="{{ asset('dashboard/vendors/@coreui/utils/js/coreui-utils.js') }}"></script>
<!-- Ajax CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="{{ asset('dashboard/js/main.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!--linear icons-->
<script src="https://cdn.linearicons.com/free/1.0.0/svgembedder.min.js"></script>

<!-- Toastr JS -->
<script src="{{ asset('dashboard/vendors/toastr/toastr.js') }}"></script>
<script>
    $(document).ready(function() {
        toastr.options.timeOut = 10000;
        @if(Session::has('t-success'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            };

        toastr.success("{{ session('t-success') }}");
        @endif

            @if(Session::has('t-error'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            };
        toastr.error("{{ session('t-error') }}");
        @endif

            @if(Session::has('t-info'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            };
        toastr.info("{{ session('t-info') }}");
        @endif

            @if(Session::has('t-warning'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            };
        toastr.warning("{{ session('t-warning') }}");
        @endif
    });
</script>


<!-- CSRF -->
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@stack('script')
