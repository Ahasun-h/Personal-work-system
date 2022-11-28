@extends('app')

<!-- Start:Title -->
@section('title','Fund Transfer Show')
<!-- End:Title -->

<!-- Start:Sub Header Menu -->
@section('sub-header-menu')
    <li class="breadcrumb-item">
        <span>Fund Transfer</span>
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
                <!-- Start:Alert -->
            @include('partials.alert')
            <!-- End:Alert -->
                <div class="card">
                    <div class="card-header">
                        <strong>Fund Transfer</strong>
                        <span class="small ms-1">
                            Show
                        </span>
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="title" class="form-label">
                                        Title<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="title" placeholder="Example" value="{{ $fundTransfer->title }}" readonly>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="date" class="form-label">
                                        Date<span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" id="date" value="{{ $fundTransfer->date }}" readonly>
                                </div>


                                <div class="col-12 col-sm-12 col-md-6 mb-3 bank_transaction">
                                    <label for="out_account" class="form-label">
                                        Account Form<span class="text-danger">*</span>
                                    </label>
                                    <select id="out_account" class="form-control" disabled>
                                        @if($fundTransfer->out_account == 0)
                                            <option>A-0001 | Cash</option>
                                        @else
                                            <option >{{ $fundTransfer->outTransactionId->bankAccount->account_number }} | {{ $fundTransfer->outTransactionId->bankAccount->account_holder_name }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 mb-3 bank_transaction" >
                                    <label for="in_account" class="form-label">
                                        Account To<span class="text-danger">*</span>
                                    </label>
                                    <select id="in_account" class="form-control" disabled>
                                        @if($fundTransfer->in_account == 0)
                                            <option>A-0001 | Cash</option>
                                        @else
                                            <option >{{ $fundTransfer->inTransactionId->bankAccount->account_number }} | {{ $fundTransfer->inTransactionId->bankAccount->account_holder_name }}</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 mb-3 bank_transaction" >
                                    <label for="cheque_number" class="form-label">
                                        Cheque Number
                                    </label>
                                    <input type="text" class="form-control" id="cheque_number" placeholder="Example" value="{{ $fundTransfer->inTransactionId->cheque_number }}" readonly>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="amount" class="form-label">
                                        Amount<span class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control" id="amount" value="{{ $fundTransfer->amount }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Note</label>
                                    <textarea class="form-control" id="note" rows="3" placeholder="Note" readonly>
                                        {!! $fundTransfer->inTransactionId->note !!}
                                    </textarea>
                                </div>
                                <div class="col-6 col-sm-4 col-md-3 d-flex">
                                    <a href="{{ url()->previous() }}" type="reset" class="form-control btn btn-danger text-white">
                                        <i class='bx bx-chevron-left'></i> Back
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- End:Content -->
