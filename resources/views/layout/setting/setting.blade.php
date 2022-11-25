@extends('app')

<!-- Start:Title -->
@section('title','Setting')
<!-- End:Title -->

<!-- Start:Sub Header Menu -->
@section('sub-header-menu')
    <li class="breadcrumb-item">
        <span>Setting</span>
    </li>
@endsection
<!-- End:Sub Header Menu -->

@push('style')
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
    <div class="container-lg">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <!-- Start:Alert -->
                @include('partials.alert')
                <!-- End:Alert -->



                <div class="d-flex align-items-start">

                    <div class="col-3 list-group nav flex-column nav-pills pe-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a href="{{ route('setting') }}" class="list-group-item list-group-item-action {{ (request()->is('setting')) ? 'active' : '' }}" >
                            General Setting
                        </a>
                        <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action {{ (request()->is('user-profile')) ? 'active' : '' }} ">
                            Profile
                        </a>
                        <a href="{{ route('user.password') }}" class="list-group-item list-group-item-action {{ (request()->is('user-password')) ? 'active' : '' }} ">
                            Password
                        </a>
                    </div>


                    <div class="col-9 tab-content" id="v-pills-tabContent">

                        <!-- Start:Setting-Tab -->
                        <div class="tab-pane {{ (request()->is('setting')) ? 'show active' : '' }}">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-content-center">
                                    <div class="d-flex align-content-center">
                                        <strong>General Setting</strong>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                                       @csrf
                                       <div class="form-group my-3">
                                           <label for="title"><b>Title</b></label>
                                           <input type="text" name="title" id="title" class="form-control" value="{{ empty($setting->title) ? 'Accounting System' : $setting->title }}">
                                           @error('title')
                                           <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                           @enderror
                                       </div>

                                       <div class="form-group my-3">
                                           <label for="logo">
                                               <b>Logo (Only image are allowed)</b>
                                           </label>
                                           @if (empty($setting->logo))
                                               <input type="file" class="form-control dropify" data-default-file="{{ asset('dashboard/image/logo_full.png') }}" name="logo" id="logo">
                                           @else
                                               <input type="file" class="form-control dropify" data-default-file="{{ asset('/'.$setting->logo) }}" name="logo" id="logo">
                                           @endif

                                           @error('logo')
                                           <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                           @enderror
                                       </div>

                                        <!-- Start:Favicon -->
                                       <div class="form-group my-3">
                                           <label for="favicon"><b>Favicon (Only image are allowed, size: 33 x 33)</b> </label>
                                           @if (empty($setting->favicon))
                                               <input type="file" class="form-control dropify" data-default-file="{{ asset('dashboard/image/logo.png') }}" name="favicon" id="favicon">
                                           @else
                                               <input type="file" class="form-control dropify" data-default-file="{{ asset('/'.$setting->favicon) }}" name="favicon" id="favicon">
                                           @endif

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
                                           <input type="text" name="address" id="address" class="form-control" value="{{ empty($setting->address) ? '26985 Brighton Lane, Lake Forest, CA 92630' : $setting->address }}">
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
                                               @if(empty($setting->description))
                                                   Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                               @else
                                                   {{ $setting->description }}
                                               @endif
                                           </textarea>
                                           @error('description')
                                           <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                           @enderror
                                       </div>

                                       <button type="submit" class="btn btn-success text-white">
                                           Update
                                       </button>

                                   </form>
                                </div>
                            </div>
                        </div>
                        <!-- End:Setting-Tab -->

                        <!-- Start:Profile-Tab -->
                        <div class="tab-pane fade {{ (request()->is('user-profile')) ? 'show active' : '' }}" >
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-content-center">
                                    <div class="d-flex align-content-center">
                                        <strong>Profile</strong>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group my-3">
                                            <label for="title"><b>Name</b></label>
                                            <input type="text" name="name" id="name" class="form-control" value="{{ auth()->user()->name }}">
                                            @error('name')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group my-3">
                                            <label for="title"><b>Name</b></label>
                                            <input type="email" name="email" id="email" class="form-control" value="{{ auth()->user()->email }}">
                                            @error('email')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="form-group my-3">
                                            <label for="logo">
                                                <b>User Avarat</b>
                                            </label>
                                            @if (empty(auth()->user()->user_avatar))
                                                <input type="file" class="form-control dropify" data-default-file="{{ asset('dashboard/image/user.png') }}" name="user_avatar" id="user_avatar">
                                            @else
                                                <input type="file" class="form-control dropify" data-default-file="{{ asset('/'.auth()->user()->user_avatar) }}" name="user_avatar" id="user_avatar">
                                            @endif
                                            @error('user_avatar')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-success text-white">
                                            Update
                                        </button>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End:Profile-Tab -->

                        <!-- Start:Password-Tab -->
                        <div class="tab-pane fade {{ (request()->is('user-password')) ? 'show active' : '' }}" >
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-content-center">
                                    <div class="d-flex align-content-center">
                                        <strong>Password</strong>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('user.password-update') }}" class="password_form" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group col-6 mb-1 px-1">
                                            <label for="old_password"><b>Old Password</b></label>
                                            <div class="input-group input-group-sm">
                                                <input type="password" class="form-control" id="old_password" name="old_password">
                                                <span class="input-group-text" id="inputGroup-sizing-lg" onclick="passwordVisisbility('old_password','old_password_icon')">
                                                    <i class="bx bx-low-vision" id="old_password_icon"></i>
                                                </span>
                                            </div>
                                            @error('old_password')
                                            <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="d-flex justify-content-between mb-2">
                                            <div class="form-group col-6 px-1">
                                                <label for="new_password"><b>New Password</b></label>
                                                <div class="input-group input-group-sm">
                                                    <input type="password" class="form-control" id="new_password" name="new_password">
                                                    <span class="input-group-text" id="inputGroup-sizing-lg" onclick="passwordVisisbility('new_password','new_password_icon')">
                                                         <i class="bx bx-low-vision" id="new_password_icon"></i>
                                                    </span>
                                                </div>
                                                @error('new_password')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-6 px-1">
                                                <label for="confirm_password"><b>Confirm Password</b></label>
                                                <div class="input-group input-group-sm">
                                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                                    <span class="input-group-text" id="inputGroup-sizing-lg" onclick="passwordVisisbility('confirm_password','confirm_password_icon')">
                                                        <i class="bx bx-low-vision" id="confirm_password_icon"></i>
                                                    </span>
                                                </div>
                                                @error('confirm_password')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success mx-1 text-white">
                                            Update
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End:Password-Tab -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- End:Content -->

<!-- Start:Script -->
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
            integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
            crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });

        ClassicEditor
            .create(document.querySelector('#description'), {
                removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    <script>

        function passwordVisisbility(input,icon){

            if($('.password_form #'+icon).hasClass('bx-low-vision')){
                $('.password_form #'+icon).removeClass('bx-low-vision');
                $('.password_form #'+icon).addClass('bx-show');
                $('.password_form #'+input).attr('type','text');
            }else {
                console.log(input);
                $('.password_form #'+icon).removeClass('bx-show');
                $('.password_form #'+icon).addClass('bx-low-vision');
                $('.password_form #'+input).attr('type','password');
            }
        }



    </script>


@endpush
<!-- End:Script -->

