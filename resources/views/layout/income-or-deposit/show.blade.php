@extends('app')

<!-- Start:Title -->
@section('title','Income | Deposit Show')
<!-- End:Title -->

<!-- Start:Sub Header Menu -->
@section('sub-header-menu')
    <li class="breadcrumb-item">
        <span>Income | Deposit</span>
    </li>
    <li class="breadcrumb-item active">
        <span>Show</span>
    </li>
@endsection
<!-- End:Sub Header Menu -->


<!-- Start:Content -->
@section('content')
    <div class="container-lg">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Income | Deposit</strong>
                        <span class="small ms-1">
                            Show
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="transaction_type" class="form-label">
                                    Transaction Type<span class="text-danger">*</span>
                                </label>
                                <select id="transaction_type" class="form-control" disabled>
                                    <option value="2" {{ $transaction->transaction_type == 2 ? 'selected' : '' }} >Deposit</option>
                                    <option value="3" {{ $transaction->transaction_type == 3 ? 'selected' : '' }} >Income</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <label for="title" class="form-label">
                                    Title<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="title" placeholder="Example" value="{{ $transaction->title }}">
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <label for="transaction_method" class="form-label">
                                    Transaction Method<span class="text-danger">*</span>
                                </label>
                                <select id="transaction_method" class="form-control" disabled>
                                    <option value="1" {{ $transaction->transaction_method == 1 ? 'selected' : '' }} >Cash</option>
                                    <option value="2" {{ $transaction->transaction_method == 1 ? 'selected' : '' }} >Bank</option>
                                </select>
                            </div>

                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <label for="date" class="form-label">
                                    Date<span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="date" value="{{ $transaction->date }}" readonly>
                            </div>

                            @if($transaction->transaction_method == 2)
                                <div class="col-12 col-sm-12 col-md-6 mb-3 bank_transaction" >
                                    <label for="account_id" class="form-label">
                                        Bank Account<span class="text-danger">*</span>
                                    </label>
                                    <select id="account_id" class="form-control" disabled>
                                        <option>{{ $transaction->bankAccount->account_number }} | {{ $transaction->bankAccount->account_holder_name }}</option>
                                    </select>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 mb-3 bank_transaction" >
                                    <label for="cheque_number" class="form-label">
                                        Cheque Number<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="cheque_number" placeholder="Example" value="{{ $transaction->cheque_number }}" readonly>
                                </div>
                            @endif

                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <label for="amount" class="form-label">
                                    Amount<span class="text-danger">*</span> <span class="text-info" id="balance"></span>
                                </label>
                                <input type="hidden" id="amount_balance">
                                <input type="number" class="form-control" id="amount" value="{{ $transaction->amount }}" readonly >
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label">Note</label>
                                <textarea class="form-control" id="note" rows="3" placeholder="Note" readonly>
                                    {!! $transaction->note !!}
                                </textarea>
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 d-flex">
                                <a href="{{ url()->previous() }}" type="reset" class="form-control btn btn-danger text-white">
                                    <i class='bx bx-chevron-left'></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- End:Content -->

