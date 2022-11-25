@extends('app')

<!-- Start:Title -->
@section('title','Accounts Statement View')
<!-- End:Title -->

<!-- Start:Sub Header Menu -->
@section('sub-header-menu')
    <li class="breadcrumb-item">
        <span>Accounts Statement</span>
    </li>
    <li class="breadcrumb-item active">
        <span>View</span>
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
                            <strong>Accounts Statement</strong>
                            <span class="small ms-1">
                                View
                            </span>
                        </div>
                        <div id="file_exports">

                        </div>
                        <div>
                            <div class="input-group input-group-sm">
                                <input type="date" class="form-control" id="start_date" placeholder="Start Date" value="">
                                <span class="input-group-text">-</span>
                                <input type="date" class="form-control" id="end_date" placeholder="End Date">
                                <button class="btn btn-outline-secondary" id="date_fliter" type="submit">Date Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="data-table" class="table table-striped w-100" >
                            <thead class="text-white">
                                <tr class="bg-primary">
                                    <th>SL#</th>
                                    <th>Account</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Balance</th>
                                </tr>
                                <tr id="previous_blance_info" class="text-black">
                                    <th>0</th>
                                    <th colspan="3">Previous</th>
                                    <th id="previousCredit"></th>
                                    <th id="previousDebit"></th>
                                    <th id="previousBalance"></th>
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

    <!-- sweetalert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <script>

        $(document).ready(function() {
                var accountId = {!! $idAccount !!};

                var url = '{{ route("account.statement",":id") }}';
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    }
                });
                var dTable = $('#data-table').DataTable({
                    order: [],
                    lengthMenu: [[10, 25, 50, 100, -1], [ "All",10, 25, 50, 100]],
                    processing: true,
                    responsive: false,
                    serverSide: true,
                    bFilter: false,
                    paging: false,
                    language: {
                        processing: '<i class="bx bx-loader-alt loding-data"></i>'
                    },

                    scroller: {
                        loadingIndicator: false
                    },
                    pagingType: "full_numbers",
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    ajax: {
                        url: url.replace(':id', accountId),
                        type: "GET",
                        data: function(d) {
                            (d.start_date = $('#start_date').val()),
                            (d.end_date = $('#end_date').val());
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'account_info', name: 'account_info', orderable: true, searchable: true},
                        {data: 'transaction_type', name: 'transaction_type', orderable: true, searchable: true},
                        {data: 'amount', name: 'amount', orderable: true, searchable: true},
                        {data: 'credit', name: 'credit', orderable: true, searchable: true},
                        {data: 'debit', name: 'debit', orderable: true, searchable: true},
                        {data: 'balance', name: 'balance', orderable: true, searchable: true},
                    ],
                    initComplete: function (data) {
                        var previousBalance = data.json.previous_balance;
                        var previousDebit = data.json.previous_debit;
                        var previousCredit = data.json.previous_credit;

                        document.getElementById('previousBalance').innerHTML = previousBalance;
                        document.getElementById('previousDebit').innerHTML = previousDebit;
                        document.getElementById('previousCredit').innerHTML = previousCredit;
                    }
                });
                dTable.buttons().container().appendTo( '#file_exports' );
                console.log("Habib"+dTable)

                // Date Fliter
                $(document).on("click", "#date_fliter", function(e) {

                    const start_date = $('#start_date').val();
                    const end_date = $('#end_date').val();

                    if(start_date >= end_date){
                        swal({
                            title: `Alert?`,
                            text: "Please, select the correct format for the date filter!",
                            buttons: true,
                            dangerMode: true,
                        }).then((willDelete) => {
                            if (willDelete) {
                                $('#start_date').val('');
                                $('#end_date').val('');
                            }
                        });
                    }else if(start_date < end_date){
                        dTable.draw();
                    }
                });
            });
    </script>
@endpush
<!-- End:Script -->
