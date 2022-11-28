@extends('app')

<!-- Start:Title -->
@section('title','Expense | Withdraw Add')
<!-- End:Title -->

<!-- Start:Sub Header Menu -->
@section('sub-header-menu')
    <li class="breadcrumb-item">
        <span>Expense | Withdraw</span>
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
                        <strong>Expense | Withdraw</strong>
                        <span class="small ms-1">
                            Add
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('expense-or-withdraw.store') }}" method="post">
                            <div class="row">
                                @csrf
                                <div class="col-12 mb-3">
                                    <label for="transaction_type" class="form-label">
                                        Transaction Type<span class="text-danger">*</span>
                                    </label>
                                    <select name="transaction_type" id="transaction_type" class="form-control">
                                        <option value="" selected disabled>Select</option>
                                        <option value="1" >Withdraw</option>
                                        <option value="5" >Expense</option>
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
                                    <input type="text" class="form-control" id="title" placeholder="Example" name="title" value="{{ old('title') }}">
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
                                    <select name="transaction_method" id="transaction_method" class="form-control" onchange="expenseTransactionType()">
                                        <option value="" selected disabled> Select</option>
                                        <option value="1">Cash</option>
                                        @if(!$accounts->isEmpty())
                                        <option value="2">Bank</option>
                                        @endif
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
                                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}">
                                    @if($errors->has('date'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('date') }}
                                        </span>
                                    @endif
                                </div>

                                @if($errors->has('transaction_method'))
                                <div class="col-12 col-sm-12 col-md-6 mb-3 bank_transaction" style="display: none">
                                    <label for="account_id" class="form-label">
                                        Bank Account<span class="text-danger">*</span>
                                    </label>
                                    <select name="account_id" id="account_id" class="form-control" onchange="getBalance()">
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}" {{ $account->is_default == 1 ? 'selected' : '' }}  >{{ $account->account_number }} | {{ $account->account_holder_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('account_id'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('account_id') }}
                                        </span>
                                    @endif
                                </div>
                                @endif

                                <div class="col-12 col-sm-12 col-md-6 mb-3 bank_transaction" style="display: none">
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
        // Hide Or View Bank Account Options And Cheque Number
        function expenseTransactionType() {
            var transactionMethod = $("#transaction_method").val();
            console.log(transactionMethod);
            if (transactionMethod == 2) {
                $('.bank_transaction').show();
                getBalance();
            } else {
                $('.bank_transaction').hide();
                var url = '{{ route("get-account-balance",":id") }}';
                $.ajax({
                    type: "GET",
                    url: url.replace(':id', 0),
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

            }
        };

        // Get Account Balance
        function getBalance() {
            var transactionMethod = $('#transaction_method').val();
            var accountId = $('#account_id').val();
            if (accountId !== null) {
                if (transactionMethod == 2) {
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
