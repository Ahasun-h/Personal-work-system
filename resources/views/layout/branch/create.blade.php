@extends('app')

<!-- Start:Title -->
@section('title','Branch Add')
<!-- End:Title -->

<!-- Start:Sub Header Menu -->
@section('sub-header-menu')
    <li class="breadcrumb-item">
        <span>Branch</span>
    </li>
    <li class="breadcrumb-item active">
        <span>Create Branch</span>
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
                        <strong>Branch</strong>
                        <span class="small ms-1">
                            Create
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('branch.store') }}" method="post">
                            <div class="row">
                                @csrf
                                <div class="col-12 mb-3">
                                    <label for="bank_id" class="form-label">
                                        Bank <span class="text-danger">*</span>
                                    </label>
                                    <select name="bank_id" id="bank_id" class="form-control">
                                        <option value="" selected> Select</option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}" >{{ $bank->bank_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('bank_id'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('bank_id') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="branch_name" class="form-label">
                                        Branch Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="branch_name" placeholder="Example" name="branch_name" value="{{ old('branch_name') }}">
                                    @if ($errors->has('branch_name'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('branch_name') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="Status" class="form-label">
                                        Publication Status <span class="text-danger">*</span>
                                    </label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="" selected disabled> Select</option>
                                        <option value="1">Published</option>
                                        <option value="0">Unpublished</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('status') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Address">
                                        {!! old('address') !!}
                                    </textarea>
                                    @if ($errors->has('address'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('address') }}
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
