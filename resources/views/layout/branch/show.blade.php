@extends('app')

<!-- Start:Title -->
@section('title','Branch View')
<!-- End:Title -->

<!-- Start:Sub Header Menu -->
@section('sub-header-menu')
    <li class="breadcrumb-item">
        <span>Branch</span>
    </li>
    <li class="breadcrumb-item active">
        <span>View Branch</span>
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
                            View
                        </span>
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="bank_id" class="form-label">
                                        Bank <span class="text-danger">*</span>
                                    </label>
                                    <select name="bank_id" id="bank_id" class="form-control" disabled>
                                        <option value="" disabled> Select</option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ $bank->id == $branch->bank_id ? 'selected' : ''  }}>{{ $bank->bank_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="branch_name" class="form-label">
                                        Branch Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="branch_name" placeholder="Example" name="branch_name" value="{{ $branch->branch_name }}" readonly>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="Status" class="form-label">
                                        Publication Status <span class="text-danger">*</span>
                                    </label>
                                    <select name="status" id="status" class="form-control" disabled>
                                        <option value="" disabled> Select</option>
                                        <option value="1" {{ $branch->status == 1 ? 'selected' : '' }} >Published</option>
                                        <option value="0" {{ $branch->status == 0 ? 'selected' : '' }}>Unpublished</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Address" readonly>
                                        {!! $branch->address !!}
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
