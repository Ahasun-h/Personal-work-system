@extends('app')

<!-- Start:Title -->
@section('title','Account Edit')
<!-- End:Title -->

<!-- Start:Sub Header Menu -->
@section('sub-header-menu')
    <li class="breadcrumb-item">
        <span>Account</span>
    </li>
    <li class="breadcrumb-item active">
        <span>Edit Account</span>
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
                        <strong>Account</strong>
                        <span class="small ms-1">
                            Edit
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('account.update',$account) }}" method="post">
                            <div class="row">
                                @csrf
                                @method('PUT')
                                <div class="col-12 mb-3">
                                    <label for="branch_id" class="form-label">
                                        Branch <span class="text-danger">*</span>
                                    </label>
                                    <select name="branch_id" id="branch_id" class="form-control">
                                        <option value="" selected> Select</option>
                                        @foreach($branchs as $branch)
                                            <option value="{{ $branch->id }}" {{ $account->branch_id == $branch->id ? 'selected' : '' }} >{{ $branch->branch_name }} | {{ $branch->bank->bank_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('branch_id'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('branch_id') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="account_number" class="form-label">
                                        Account Number <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="account_number" placeholder="Example" name="account_number" value="{{ $account->account_number }}">
                                    @if ($errors->has('account_number'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('account_number') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="account_holder_name" class="form-label">
                                        Holder Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="account_holder_name" placeholder="Example" name="account_holder_name" value="{{ $account->account_holder_name }}">
                                    @if ($errors->has('account_holder_name'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('account_holder_name') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="is_default" class="form-label">
                                        Set Default Account<span class="text-danger">*</span>
                                    </label>
                                    <select name="is_default" id="is_default" class="form-control">
                                        <option value="1" {{ $account->is_default == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $account->is_default == 0 ? 'selected' : '' }} >Not</option>
                                    </select>
                                    @if ($errors->has('is_default'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('is_default') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="Status" class="form-label">
                                        Publication Status <span class="text-danger">*</span>
                                    </label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ $account->status == 1 ? 'selected' : '' }} >Published</option>
                                        <option value="0" {{ $account->status == 0 ? 'selected' : '' }}>Unpublished</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('status') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="note" class="form-label">Note</label>
                                    <textarea class="form-control" name="note" id="note" rows="3" placeholder="Note...">
                                        {!! $account->note !!}
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
