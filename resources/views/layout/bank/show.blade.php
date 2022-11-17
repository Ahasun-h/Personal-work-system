@extends('app')

<!-- Start:Title -->
@section('title','Bank View')
<!-- End:Title -->

<!-- Start:Sub Header Menu -->
@section('sub-header-menu')
    <li class="breadcrumb-item">
        <span>Bank</span>
    </li>
    <li class="breadcrumb-item active">
        <span>View Bank</span>
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
                        <strong>Bank</strong>
                        <span class="small text-info ms-1">
                            Show
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <label for="bank_name" class="form-label">Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="bank_name" placeholder="Example" name="bank_name" value="{{ $bank->bank_name }}" readonly>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <label for="name" class="form-label">Publication Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control" disabled>
                                    <option value="1" {{ $bank->status == 1 ? 'selected' : ''}}>Published</option>
                                    <option value="0" {{ $bank->status == 0 ? 'selected' : ''}}>Unpublished</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3"
                                          placeholder="Description.." readonly>{!!  $bank->description !!}</textarea>
                            </div>
                            <div class="col-4 col-sm-3 col-md-2 d-flex">
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
