@extends('app')

<!-- Start:Title -->
@section('title','Accounts Balance Sheet')
<!-- End:Title -->

<!-- Start:Sub Header Menu -->
@section('sub-header-menu')
    <li class="breadcrumb-item">
        <span>Balance Sheet</span>
    </li>
    <li class="breadcrumb-item active">
        <span>Account's</span>
    </li>
@endsection
<!-- End:Sub Header Menu -->

@push('style')
    <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" />
@endpush


<!-- Start:Content -->
@section('content')
    <div class="container-lg">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <!-- Start:Alert -->
            @include('partials.alert')
            <!-- End:Alert -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-content-center">
                        <div class="d-flex align-content-center">
                            <strong>Balance Sheet</strong>
                            <span class="small ms-1">
                                Account's
                            </span>
                        </div>
                        <div id="file_exports">

                        </div>
                    </div>
                    <div class="card-body">
                        <table id="data-table" class="table table-striped w-100" >
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>SL#</th>
                                    <th>Account</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Balance</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- End:Content -->

<!-- Start:Script -->
@push('script')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            var searchable = [];
            var selectable = [];
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });
            var dTable = $('#data-table').DataTable({
                order: [],
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                processing: true,
                responsive: false,
                serverSide: true,
                language: {
                    processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
                },

                scroller: {
                    loadingIndicator: false
                },
                pagingType: "full_numbers",
                dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                ajax: {
                    url: "{{route('account.balance-sheet')}}",
                    type: "get"
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'account_info', name: 'account_info', orderable: true, searchable: true},
                    {data: 'credit', name: 'credit', orderable: true, searchable: true},
                    {data: 'debit', name: 'debit', orderable: true, searchable: true},
                    {data: 'balance', name: 'balance', orderable: true, searchable: true},
                    //only those have manage_user permission will get access
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
            });

            dTable.buttons().container().appendTo( '#file_exports' );
        });
    </script>
@endpush
<!-- End:Script -->
