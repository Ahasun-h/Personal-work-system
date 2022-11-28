@extends('setup.setup_app')

<!-- Start:Title -->
@section('title','Setting Setup')
<!-- End:Title -->

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
        .ck-editor__editable[role="textbox"] {
            min-height: 150px;
        }
    </style>
@endpush

<!-- Start:Content -->
@section('content')
    <div class="container">
        <div class="card">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-primary text-primary text-uppercase fw-bold m-0">Setting Setup</h5>
                </div>
                <div class="card-body">
                    <!-- Start:Alert -->
                    @include('partials.alert')
                    <!-- End:Alert -->

                    <form action="{{ route('setup.setting.save') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="my-3">
                            <label for="title"><b>Title</b></label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                            @error('title')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="my-3">
                            <label for="logo">
                                <b>Logo (Only image are allowed)</b>
                            </label>
                            <input type="file" class="form-control dropify" data-default-file="{{ asset('dashboard/image/logo_full.png') }}" name="logo" id="logo">
                            @error('logo')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Start:Favicon -->
                        <div class="form-group my-3">
                            <label for="favicon"><b>Favicon (Only image are allowed, size: 33 x 33)</b> </label>
                            <input type="file" class="form-control dropify" data-default-file="{{ asset('dashboard/image/logo.png') }}" name="favicon" id="favicon">
                            @error('favicon')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- End:Favicon -->

                        <!-- Start:Address -->
                        <div class="form-group my-3">
                            <label for="address"> <b>Address</b> </label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                            @error('address')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- End:Address -->

                        <div class="form-group my-3">
                            <label for="description"> <b>Description</b> </label>
                            <textarea name="description" class="form-control" id="description" cols="30" rows="10">
                                {{ old('description') }}
                            </textarea>
                            @error('description')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
<!-- End:Content -->

@push('script')

    <!-- Ajax CDN -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
            integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
            crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify();


            ClassicEditor
                .create(document.querySelector('#description'), {
                    removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
                })
                .catch(error => {
                    console.error(error);
                });
        });


    </script>
@endpush
