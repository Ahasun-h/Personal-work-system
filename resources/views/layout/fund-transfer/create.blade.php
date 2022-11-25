@extends('app')

<!-- Start:Title -->
@section('title','Fund Transfer Add')
<!-- End:Title -->

<!-- Start:Sub Header Menu -->
@section('sub-header-menu')
<li class="breadcrumb-item">
    <span>Fund Transfer</span>
</li>
<li class="breadcrumb-item active">
    <span>Add</span>
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
                            Add
                        </span>
                </div>
                <div class="card-body">
                    <form action="{{ route('fund-transfer.store') }}" method="post">
                        <div class="row">
                            @csrf
                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <label for="title" class="form-label">
                                    Title<span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="title" placeholder="Example" name="title" value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                <span class="help-block text-danger">
                                    {{ $errors->first('title') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <label for="date" class="form-label">
                                    Date<span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}">
                                @if ($errors->has('date'))
                                    <span class="help-block text-danger">
                                        {{ $errors->first('date') }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 mb-3 bank_transaction">
                                <label for="out_account" class="form-label">
                                    Account Form<span class="text-danger">*</span>
                                </label>
                                <select name="out_account" id="out_account" class="form-control" onchange="getBalance()">
                                    <option value="0">A-0001 | Cash</option>
                                    @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ $account->is_default == 1 ? 'selected' : '' }}  >{{ $account->account_number }} | {{ $account->account_holder_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('out_account'))
                                <span class="help-block text-danger">
                                    {{ $errors->first('out_account') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 mb-3 bank_transaction" >
                                <label for="in_account" class="form-label">
                                    Account To<span class="text-danger">*</span>
                                </label>
                                <select name="in_account" id="in_account" class="form-control">
                                    <option value="" >Select</option>
                                    <option value="0">A-0001 | Cash</option>
                                    @foreach($accounts as $account)
                                        <option id="{{ $account->id }}" value="{{ $account->id }}" >{{ $account->account_number }} | {{ $account->account_holder_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('in_account'))
                                <span class="help-block text-danger">
                                    {{ $errors->first('in_account') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 mb-3 bank_transaction" >
                                <label for="cheque_number" class="form-label">
                                    Cheque Number
                                </label>
                                <input type="text" class="form-control" id="cheque_number" name="cheque_number" placeholder="Example" value="{{ old('cheque_number') }}">
                                @if ($errors->has('cheque_number'))
                                <span class="help-block text-danger">
                                    {{ $errors->first('cheque_number') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <label for="amount" class="form-label">
                                    Amount<span class="text-danger">*</span> <span class="text-info" id="balance" style="display: none"></span>
                                </label>
                                <input type="hidden" id="amount_balance">
                                <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" placeholder="0.00" min="0" onkeyup="checkAmount(this)" >
                                @if ($errors->has('amount'))
                                <span class="help-block text-danger">
                                    {{ $errors->first('amount') }}
                                </span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Note</label>
                                <textarea class="form-control" name="note" id="note" rows="3" placeholder="Note">
                                    {!! old('note') !!}
                                </textarea>
                                @if ($errors->has('note'))
                                <span class="help-block text-danger">
                                    {{ $errors->first('note') }}
                                </span>
                                @endif
                            </div>
                            <div class="col-6 col-sm-4 col-md-3 d-flex">
                                <button type="submit" class="form-control btn btn-success text-white">
                                    Submit
                                </button>
                                <button type="reset" class="form-control btn btn-danger text-white mx-2">
                                    Cancel
                                </button>
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

<!-- Start:Script -->
@push('script')
<!-- sweetalert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>

    // Function Reload After Reload
    window.onload = function() {
        getBalance()
    }

    // Get Account Balance
    function getBalance() {
        var accountId = $('#out_account').val();
        console.log(accountId);
        if (accountId !== null) {
            var url = '{{ route("get-account-balance",":id") }}';
            $.ajax({
                type: "GET",
                url: url.replace(':id', accountId),
                success: function (resp) {
                    $('#balance').show();
                    document.getElementById('balance').innerHTML = '( ' + resp + ' )';
                    $('#amount_balance').val(resp);
                    console.log(resp);
                    document.getElementById('amount').max = resp;
                }, // success end
                error: function (error) {
                    // location.reload();
                } // Error
            })
        } else {
            $('#balance').hide();
        }
    }

    // Check
    function checkAmount(amount) {
        var amount = amount.value;
        var amountBalance = $('#amount_balance').val();
        if (parseFloat(amountBalance) < parseFloat(amount)) {
            swal({
                title: `Alert?`,
                text: "You don't have enough balance.",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $('#amount').val(0);
                }
            });
        }
    }
</script>
@endpush
