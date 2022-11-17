@extends('app')

<!-- Start:Title -->
@section('title','Bank Create')
<!-- End:Title -->

<!-- Start:Sub Header Menu -->
@section('sub-header-menu')
    <li class="breadcrumb-item">
        <span>Bank</span>
    </li>
    <li class="breadcrumb-item active">
        <span>Create Bank</span>
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
                        <span class="small ms-1">
                            Create
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('bank.store') }}" method="post">
                            <div class="row">
                                @csrf
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="bank_name" class="form-label">
                                        Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="bank_name" placeholder="Example" name="bank_name" value="{{ old('bank_name') }}">
                                    @if ($errors->has('bank_name'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('bank_name') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <label for="status" class="form-label">
                                        Publication Status
                                        <span class="text-danger">*</span>
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
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="3"
                                              placeholder="Description..">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="help-block text-danger">
                                            {{ $errors->first('description') }}
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
