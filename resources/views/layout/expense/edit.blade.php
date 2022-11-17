@extends('app')

<!-- Start:Title -->
@section('title','Expense Edit')
<!-- End:Title -->

<!-- Start:Sub Header Menu -->
@section('sub-header-menu')
    <li class="breadcrumb-item">
        <span>Expense</span>
    </li>
    <li class="breadcrumb-item active">
        <span>Edit Expense</span>
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
                        <strong>Expense</strong>
                        <span class="small ms-1">
                            Edit
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('expense.update',$expense) }}" method="post">
                            <div class="row">
                                @csrf
                                @method('PUT')
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="expense_title" class="form-label">
                                        Expense Title<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="expense_title" placeholder="Example" name="expense_title" value="{{ $expense->expense_title }}">
                                    @if ($errors->has('expense_title'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('expense_title') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="transaction_way" class="form-label">
                                        Transaction Type<span class="text-danger">*</span>
                                    </label>
                                    <select name="transaction_way" id="transaction_way" class="form-control"  disabled>
                                        <option value="1" {{ $expense->transaction_way == 1 ? 'selected' : '' }}>Cash</option>
                                        <option value="2" {{ $expense->transaction_way == 2 ? 'selected' : '' }}>Bank</option>
                                    </select>
                                    @if ($errors->has('transaction_way'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('transaction_way') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="expense_date" class="form-label">
                                        Date<span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" id="expense_date" name="expense_date" value="{{ $expense->expense_date }}">
                                    @if ($errors->has('expense_date'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('expense_date') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 mb-3 bank_transaction" style="display: {{ $expense->transaction_way == 1 ? 'none' : '' }}">
                                    <label for="account_id" class="form-label">
                                        Bank Account<span class="text-danger">*</span>
                                    </label>
                                    <select name="account_id" id="account_id" class="form-control" onchange="getBalance()">
                                        <option value="" selected disabled> Select</option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}" {{ $expense->transaction->account_id == $account->id ? 'selected' : '' }}>{{ $account->branch->branch_name }} | {{ $account->branch->bank->bank_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('account_id'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('account_id') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 mb-3 bank_transaction" style="display: {{ $expense->transaction_way == 1 ? 'none' : '' }}">
                                    <label for="cheque_number" class="form-label">
                                        Cheque Number<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="cheque_number" name="cheque_number" placeholder="Example" value="{{ $expense->transaction->cheque_number }}">
                                    @if ($errors->has('cheque_number'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('cheque_number') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="amount" class="form-label">
                                        Amount<span class="text-danger">*</span> <span class="text-info" id="balance"> ( {{ $balance }} ) </span>
                                    </label>
                                    <input type="hidden" id="amount_balance" value="{{ $expense->amount }}">
                                    <input type="number" class="form-control" id="amount" name="amount" value="{{ $expense->amount }}" placeholder="0.00" min="0" onkeyup="checkAmount(this)" >
                                    @if ($errors->has('amount'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('amount') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Note</label>
                                    <textarea class="form-control" name="note" id="note" rows="3" placeholder="Note">
                                        {!! $expense->transaction->description !!}
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
            var transactionType = $('#transaction_way').val();
            var accountId = $('#account_id').val();
            if (accountId !== null) {
                if (transactionType == 2) {
                    var url = '{{ route("get-account-balance",":id") }}';
                    $.ajax({
                        type: "GET",
                        url: url.replace(':id', accountId),
                        success: function (resp) {
                            $('#balance').show();
                            document.getElementById('balance').innerHTML = '( ' + resp + ' )';
                            $('#amount_balance').val(resp);
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
