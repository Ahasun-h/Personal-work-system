@extends('app')

@section('title','dashboard')

<!-- Start:Sub Header Menu -->
@section('sub-header-menu')
    <li class="breadcrumb-item">
        <span>Dashboard</span>
    </li>
@endsection
<!-- End:Sub Header Menu -->

@push('style')
    <link href="{{ asset('dashboard/vendors/chart.js/css/coreui-chartjs.css') }}" />
@endpush


@section('content')
    <div class="container-lg">
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4 text-white bg-primary">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">
                                {{ $bankAccount + 1 }}
                            </div>
                            <div>Bank Account's</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4 text-white bg-info">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">
                                $ {{ $debit }}
                            </div>
                            <div>Total Debit</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4 text-white bg-warning">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">
                                $ {{ $credit }}
                            </div>
                            <div>Total Credit</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4 text-white bg-danger">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">
                                $ {{ $balance }}
                            </div>
                            <div>Total Balance</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title mb-0">Transaction</h4>
                        <div class="small text-medium-emphasis">2022</div>
                    </div>
                </div>
                <div class="c-chart-wrapper chart-container" style="position: relative;height: auto;width: 100%;">
                    <canvas class="chart" id="myChart" height="300"></canvas>
                </div>
            </div>

        </div>

    </div>
@endsection


<!-- Start:Script -->
@push('script')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        new Chart(document.getElementById("myChart"), {
            type: 'line',
            data: {
                labels: {!! json_encode($month) !!},
                datasets: [
                    {
                        data: {!!json_encode($credit_array)!!},
                        label: "Cash-In(Credit)",
                        borderColor: "#3e95cd",
                        fill: false
                    },
                    {
                        data: {!!json_encode($debit_array)!!},
                        label: "Cash-Out(Debit)",
                        borderColor: "#8e5ea2",
                        fill: false
                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'World population per region (in millions)'
                },
                maintainAspectRatio: false,
            }

        });
    </script>

@endpush
<!-- End:Script -->


