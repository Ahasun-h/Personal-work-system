@extends('app')

<!-- Start:Title -->
@section('title','Expense | Withdraw Edit')
<!-- End:Title -->

<!-- Start:Sub Header Menu -->
@section('sub-header-menu')
    <li class="breadcrumb-item">
        <span>Expense | Withdraw</span>
    </li>
    <li class="breadcrumb-item active">
        <span>Edit</span>
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
                        <strong>Expense | Withdraw</strong>
                        <span class="small ms-1">
                            Edit
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('expense-or-withdraw.update', $expense_or_withdraw ) }}" method="post" >
                            <div class="row">
                                @csrf
                                @method('PUT')
                                <div class="col-12 mb-3">
                                    <label for="transaction_type" class="form-label">
                                        Transaction Type<span class="text-danger">*</span>
                                    </label>
                                    <select name="transaction_type" id="transaction_type" class="form-control">
                                        <option value="" selected disabled>Select</option>
                                        <option value="1" {{ $expense_or_withdraw->transaction_type == 1 ? 'selected' : '' }} >Withdraw</option>
                                        <option value="5" {{ $expense_or_withdraw->transaction_type == 5 ? 'selected' : '' }} >Expense</option>
                                    </select>
                                    @if ($errors->has('transaction_type'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('transaction_type') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="title" class="form-label">
                                        Title<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="title" placeholder="Example" name="title" value="{{ $expense_or_withdraw->title }}">
                                    @if ($errors->has('title'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('title') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="transaction_method" class="form-label">
                                        Transaction Method<span class="text-danger">*</span>
                                    </label>
                                    <select id="transaction_method" class="form-control" disabled>
                                        <option value="1" {{ $expense_or_withdraw->transaction_method == 1 ? 'selected' : '' }} >Cash</option>
                                        <option value="2" {{ $expense_or_withdraw->transaction_method == 2 ? 'selected' : '' }} >Bank</option>
                                    </select>
                                    @if ($errors->has('transaction_method'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('transaction_method') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="date" class="form-label">
                                        Date<span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" id="date" name="date" value="{{ $expense_or_withdraw->date }}">
                                    @if ($errors->has('date'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('date') }}
                                        </span>
                                    @endif
                                </div>

                                @if($expense_or_withdraw->transaction_method == 2)
                                <div class="col-12 col-sm-12 col-md-6 mb-3 bank_transaction">
                                    <label for="account_id" class="form-label">
                                        Bank Account<span class="text-danger">*</span>
                                    </label>
                                    <select name="account_id" id="account_id" class="form-control" onchange="getBalance()">
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}" {{ $account->id == $expense_or_withdraw->account_id ? 'selected' : '' }} class="{{ $account->status == 0 ? 'bg-danger text-white' : '' }}" {{ $account->status == 0 ? 'disabled' : '' }} >{{ $account->account_number }} | {{ $account->account_holder_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('account_id'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('account_id') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3 bank_transaction">
                                    <label for="cheque_number" class="form-label">
                                        Cheque Number
                                    </label>
                                    <input type="text" class="form-control" id="cheque_number" name="cheque_number" placeholder="Example" value="{{ $expense_or_withdraw->cheque_number }}">
                                    @if ($errors->has('cheque_number'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('cheque_number') }}
                                        </span>
                                    @endif
                                </div>
                                @endif

                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="amount" class="form-label">
                                        Amount<span class="text-danger">*</span> <span class="text-info" id="balance"> ( {{ $balance }} ) </span>
                                    </label>
                                    <input type="hidden" id="amount_balance" value="{{ $balance }}">
                                    <input type="number" class="form-control" id="amount" name="amount" value="{{  $expense_or_withdraw->amount }}" placeholder="0.00" min="0" max="{{ $balance }}" onkeyup="checkAmount(this)" >
                                    @if ($errors->has('amount'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('amount') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Note</label>
                                    <textarea class="form-control" name="note" id="note" rows="3" placeholder="Note">
                                        {!!  $expense_or_withdraw->note !!}
                                    </textarea>
                                    @if ($errors->has('note'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('note') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-6 col-sm-4 col-md-3 d-flex">
                                    <button type="submit" class="form-control btn btn-info text-white">
                                        Update
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
        // Get Account Balance
        function getBalance() {
            var transactionMethod = $('#transaction_method').val();
            var accountId = $('#account_id').val();
            var expenseAccountId = {!! $expense_or_withdraw->account_id !!};
            var amount = {{ $expense_or_withdraw->amount }}
            if (accountId !== null) {
                if (transactionMethod == 2) {
                    var url = '{{ route("get-account-balance",":id") }}';
                    $.ajax({
                        type: "GET",
                        url: url.replace(':id', accountId),
                        success: function (resp) {
                            $('#balance').show();
                            if( accountId == expenseAccountId ){
                                var result = amount + resp;
                                document.getElementById('balance').innerHTML = '( ' + result + ' )';
                                $('#amount_balance').val(result);
                                document.getElementById('amount').max = result;
                            }
                            else{
                                document.getElementById('balance').innerHTML = '( ' + resp + ' )';
                                $('#amount_balance').val(resp);
                                document.getElementById('amount').max = resp;
                            }

                        }, // success end
                        error: function (error) {
                            // location.reload();
                        } // Error
                    })
                } else {
                    $('#balance').hide();
                }
            }
        }

        // Check
        function checkAmount(amount) {
            var amount = amount.value;
            var amountBalance = $('#amount_balance').val();
            console.log("amount_balance"+amountBalance);
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
