<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Qatara Family Resort</title>

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('website/img/favicon.png') }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('bootstrap-4.3.1/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/magnific-popup.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('website/css/font-awesome.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('website/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('webfonts/fontawesome-pro-5.12.0-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->

    {{-- Font --}}
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="{{ asset('font/fonts.googleapis.com-css-family=Nunito.css') }}">

    @yield('style')
</head>

<body>
    {{-- header start --}}
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid p-0">
                    <div class="row align-items-center no-gutters">
                        <div class="col-xl-5 col-lg-6">
                            <div class="main-menu  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="{{ route('resort.index') }}">Home</a></li>
                                        <li><a href="#">Rooms</a></li>
                                        <li><a href="#">About</a></li>
                                        {{-- <li><a href="#">blog <i class="ti-angle-down"></i></a>
                                            <ul class="submenu">
                                                <li><a href="blog.html">blog</a></li>
                                                <li><a href="single-blog.html">single-blog</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">pages <i class="ti-angle-down"></i></a>
                                            <ul class="submenu">
                                                <li><a href="elements.html">elements</a></li>
                                            </ul>
                                        </li> --}}
                                        <li><a href="#">Contact</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2">
                            {{-- <div class="logo-img">
                                <a href="{{ route('resort.index') }}">
                                    <img src="{{ asset('website/img/logo.png') }}" alt="">
                                </a>
                            </div> --}}
                        </div>
                        <div class="col-xl-5 col-lg-4 d-none d-lg-block">
                            <div class="book_room">
                                <div class="socail_links">
                                    <ul>
                                        <li>
                                            <a href="https://www.facebook.com/PearlofQatarAlaminos" target="blank">
                                                <i class="fa fa-facebook-square"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-instagram"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="book_btn d-none d-lg-block">
                                    @auth
                                    @if (!is_null(Auth::user()->email_verified_at))
                                    <a href="{{ route('client_bookings.index') }}">Book A Room</a>
                                    @endif
                                    @endauth
                                    @guest
                                    <a class="popup-with-form" href="#login-form">Login</a>
                                    @else
                                    @auth
                                        <a class="popup-with-form" href="#account-options">
                                            Welcome {{ Auth::user()->first_name }}
                                        </a>
                                        @endauth
                                    @endguest
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    {{-- header end here --}}

    {{-- content here --}}
    @yield("content")

    <div id="modalAjax"></div>
    <div id="modalOpenData"></div>
    <div id="tableActionModal"></div>
    <div class="d-none" id="oldInput">
        @forelse (old() as $input => $value)
            @if (is_array($value))
                @foreach ($value as $arrayValue)
                    <input type="text" name="old_{{ $input }}[]" value="{{ $arrayValue }}">
                @endforeach
            @else
                <input type="text" name="old_{{ $input }}" value="{{ $value }}" data-error="{{ $errors->has($input) ? ' is-invalid' : '' }}" data-error-message="{{ $errors->first($input) }}">
            @endif
        @empty
        @endforelse
    </div>
    @if (count($errors) > 0)
        <div style="position: absolute; top: 0; right: 0; z-index: 1111">
            <div class="toast" data-autohide="false" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    {{-- <img src="..." class="rounded mr-2" alt="..."> --}}
                    <strong class="mr-auto text-danger">Whoops!</strong>
                    {{-- <small class="text-muted">11 mins ago</small> --}}
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                </div>
                <div class="toast-body">
                    {{-- There were some problems with your input. --}}
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="modal fade" id="modalAjaxError" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="DoctorsNotes" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title text-danger"><i class="fad fa-exclamation-triangle"></i> Error</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    {{-- <div id="ajaxOptions"></div> --}}
                    <legend id="thrownError"></legend>
                    <div id="xhr"></div>
                </div>
                <div class="modal-footer text-right">
                    <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- book form --}}
    {{-- <form id="book-form" class="white-popup-block mfp-hide form-contact" autocomplete="off">
        <div class="popup_box ">
            <div class="popup_inner">
                <h3>Check Availability</h3>
                <form action="#">
                    <div class="row">
                        <div class="col-xl-6">
                            <input id="datepicker" placeholder="Check in date">
                        </div>
                        <div class="col-xl-6">
                            <input id="datepicker2" placeholder="Check out date">
                        </div>
                        <div class="col-xl-12">
                            <input class="form-control w-100" nanme="number_of_person" type="number" placeholder="Number of Person">
                            <br>
                        </div>
                        <div class="col-xl-12">
                            <select class="form-select wide" id="default-select" name="room_type">
                                @foreach($roomTypes as $id=>$name)
                                    <option value="{{ $id }}" {{ request()->input('room_type') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-12">
                            <button type="button" class="boxed-btn3">Check Availability</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </form>
 --}}
    @guest
    {{-- Login form --}}
    <form id="login-form" class="white-popup-block mfp-hide form-contact" autocomplete="on">
        <div class="popup_box ">
            <div class="popup_inner">
                <h3>Login</h3>
                @csrf
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>
                    <input id="loginEmail" name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">
                    @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                    </div>
                    <input id="loginPassword" name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">
                    @if($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <label style="color: red" id="error-msg"></label>
                </div>
                <div class="input-group mb-4">
                    <div class="form-check checkbox">
                        <input class="form-check-input" name="remember" type="checkbox" id="remember" style="vertical-align: middle;" />
                        <label class="form-check-label" for="remember" style="vertical-align: middle;">
                            {{ trans('global.remember_me') }}
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <button type="submit" class="boxed-btn3">
                            {{ trans('global.login') }}
                        </button>
                    </div>
                    <div class="col-6 text-right">
                        @if(Route::has('password.request'))
                            <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                {{ trans('global.forgot_password') }}
                            </a><br>
                        @endif
                        <a class="popup-with-form btn btn-link px-0" href="#registration-form">
                            Doesn't have an account? Register Here
                        </a><br>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form class="white-popup-block mfp-hide form-contact" id="registration-form" method="POST" action="{{ route('register') }}">
        <div class="popup_box ">
            <div class="popup_inner">
                <h3>Register</h3>
                @csrf
                
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>
                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required>

                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="contact_number" class="col-md-4 col-form-label text-md-right">{{ __('Contact #') }}</label>
                        <input id="contact_number" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" required>

                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required>
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="registerEmail" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                    <div class="col-md-6">
                        <input id="registerEmail" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="registerPassword" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                    <div class="col-md-6">
                        <input id="registerPassword" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <i>Password must consist of 8</i>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="boxed-btn3">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @endguest

    @auth
    <div id="account-options" class="white-popup-block mfp-hide" autocomplete="off">
        <div class="popup_box ">
            <div class="popup_inner">
                <h3>Account</h3>
                <div class="main-menu  d-none d-lg-block">
                    <nav>
                        <ul>
                            @if (!is_null(Auth::user()->email_verified_at))
                            <li><a href="#">Bookings</a></li>
                            <li><a href="#">Account Settings</a></li>
                            @endif
                            <li><a href="#logout" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">Logout</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    @endauth

    {{-- footer --}}
    <footer class="footer">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-lg-4">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                address
                            </h3>
                            <p class="footer_text"> 069 Brgy. Magsaysay, Alaminos City, <br>
                                Pangasinan Philippines</p>
                            {{-- <a href="#" class="line-button">Get Direction</a> --}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-lg-4">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Reservation
                            </h3>
                            <p class="footer_text">+639206934160 <br>
                                qatarafamilyresort.69@gmail.com</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-lg-4">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Navigation
                            </h3>
                            <ul>
                                <li><a href="{{ route('resort.index') }}">Home</a></li>
                                <li><a href="#">Rooms</a></li>
                                <li><a href="#">About</a></li>
                                {{-- <li><a href="#">News</a></li> --}}
                            </ul>
                        </div>
                    </div>
                    {{-- <div class="col-xl-4 col-md-6 col-lg-4">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Newsletter
                            </h3>
                            <form action="#" class="newsletter_form">
                                <input type="text" placeholder="Enter your mail">
                                <button type="submit">Sign Up</button>
                            </form>
                            <p class="newsletter_text">Subscribe newsletter to get updates</p>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="copy-right_text">
            <div class="container">
                <div class="footer_border"></div>
                <div class="row">
                    <div class="col-xl-8 col-md-7 col-lg-9">
                        <p class="copy_right">
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved{{--  | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib --}}</a>
        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                    <div class="col-xl-4 col-md-5 col-lg-3">
                        <div class="socail_links">
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-facebook-square"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="{{ asset('website/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ asset('website/plugins/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('website/js/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap-4.3.1/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('website/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('website/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('website/js/ajax-form.js') }}"></script>
    {{-- <script src="{{ asset('website/js/waypoints.min.js') }}"></script> --}}
    <script src="{{ asset('website/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('website/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('website/js/scrollIt.js') }}"></script>
    <script src="{{ asset('website/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('website/js/wow.min.js') }}"></script>
    <script src="{{ asset('website/js/nice-select.min.js') }}"></script>
    <script src="{{ asset('website/js/jquery.slicknav.min.js') }}"></script>
    <script src="{{ asset('website/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('website/js/plugins.js') }}"></script>
    <script src="{{ asset('website/js/gijgo.min.js') }}"></script>

    <script src="{{ asset('website/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('website/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        $(function() {
            $.fn.select2.defaults.set('theme', 'bootstrap4');
            $.fn.select2.defaults.set('placeholder', 'Select');

            $('.select2').select2({
                theme: "bootstrap4",
                placeholder: "Select",
            });
            
            $('.select2-allow-clear').select2({
                theme: "bootstrap4",
                placeholder: "Select",
                allowClear: true
            });
    
            $('.select2-no-search').select2({
                theme: "bootstrap4",
                placeholder: "Select",
                allowClear: true,
                minimumResultsForSearch: Infinity
            });
    
            $('.select2-tag').select2({
                theme: "bootstrap4",
                placeholder: "Select",
                allowClear: true,
                tags: true,
            });
            
        });
    </script>

    <!--contact js-->
    <script src="{{ asset('website/js/contact.js') }}"></script>
    <script src="{{ asset('website/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('website/js/jquery.form.js') }}"></script>
    <script src="{{ asset('website/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('website/js/mail-script.js') }}"></script>

    <script src="{{ asset('website/js/main.js') }}"></script>
    <script>
        $('#datepicker').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
             rightIcon: '<span class="fa fa-caret-down"></span>'
         }
        });
        $('#datepicker2').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
            rightIcon: '<span class="fa fa-caret-down"></span>'
         }

        });
    </script>

    @auth
    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    <form id="verificationEmail" action="{{ url('/email/verification-notification') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    @endauth

    {{-- login Script ajax --}}
    <script>
        $(function(){
            $('#login-form').on('submit', function(e){
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:'POST',
                    url:'/login',
                    data: {
                        email: $('#loginEmail').val(),
                        password: $('#loginPassword').val()
                    },
                    success:function(response) {
                        if(response.error_msg){
                            console.log(response.error_msg)
                            $("#error-msg").html(response.error_msg);
                        }
                        if(response.redirect){
                            console.log(response.redirect)
                            window.location.href = response.redirect;
                        }
                    }
                });
            });
        })
    </script>

    {{-- My Scripts --}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // $(function(){
            $(".tr-link").click(function() {
                window.location = $(this).data("href");
            });
            $(document).on('click', 'tr[data-toggle="tr-link"]', function(){
                window.location = $(this).data("href");
            })
            
            // Permission Denied
            function ajax_error(xhr, ajaxOptions, thrownError){
                // console.log(xhr.responseJSON)
                if(xhr.responseJSON.exception == "Spatie\\Permission\\Exceptions\\UnauthorizedException"){
                    ajax_permission_denied();
                }else{
                    $('#ajaxOptions').html(ajaxOptions);
                    $('#thrownError').html(thrownError);
                    $('#xhr').html(xhr.responseJSON.message);
                    $('#modalAjaxError').modal('show');
                }
                /*Swal.fire({
                    // position: 'top-end',
                    type: 'error',
                    title: ajaxOptions+":\n"+thrownError+".\n"+xhr.responseJSON.message,
                    // showConfirmButton: false,
                    // timer: 3000,
                    // toast: true
                })*/
            }

            function ajax_permission_denied(){
                Swal.fire({
                    // position: 'top-end',
                    type: 'error',
                    title: "Access Denied",
                    text: "User does not have the right permissions.",
                    // showConfirmButton: false,
                    // timer: 3000,
                    // toast: true
                })
            }

            function removeLocationHash(){
                var noHashURL = window.location.href.replace(/#.*$/, '');
                window.history.replaceState('', document.title, noHashURL)
            }

            // Modal Ajax
            $(document).on('click', '[data-toggle="modal-ajax"]', function(){
                $('#loader').show();
                var href = $(this).data('href');
                var target = $(this).data('target');
                var data = {};
                if($(this).data('form') != null){
                    var form = $(this).data('form').split(';');
                    for (var i = 0; i < form.length; i++) {
                        var form_data = form[i].split(':');
                        for(var j = 1; j < form_data.length; j++){
                            data[form_data[j-1]] = form_data[j];
                        }
                    }
                }
                $.ajax({
                    type: 'GET',
                    url: href,
                    data: data,
                    success: function(data){
                        $('.modal-backdrop').remove()
                        $('#modalAjax').html(data.modal_content)
                        $('.select2').select2({
                            theme: "bootstrap4",
                            placeholder: "Select",
                            allowClear: true
                        });
                        $('.datetimepicker').datetimepicker();
                        $('#oldInput').find('input').each(function(){
                            var name = $(this).attr('name').replace('old_', '');
                            if(name != '_token'){
                                var value = $(this).val();
                                $('#modalAjax [name="'+name+'"]').parent('.form-group').find('.invalid-feedback').html('<strong class="text-danger">'+$(this).data('error-message')+'</strong>')
                                $('#modalAjax').find('input[type="text"][name="'+name+'"]').val(value).addClass($(this).data('error'));
                                $('#modalAjax').find('input[type="checkbox"][name="'+name+'"][value="'+value+'"]').prop('checked', true);
                                $('#modalAjax').find('input[type="radio"][name="'+name+'"][value="'+value+'"]').prop('checked', true);
                                $('#modalAjax').find('select[name="'+name+'"]').val(value).trigger('change').addClass($(this).data('error'));
                            }
                        })
                        $(target).modal('show')
                        $('#loader').hide();
                    },
                    error: function(xhr, ajaxOptions, thrownError){
                        ajax_error(xhr, ajaxOptions, thrownError)
                        // removeLocationHash()
                        $('#loader').hide();
                    }
                })
            })

            $(document).on('click', '[data-dismiss="modal-ajax"]', function() {
                // closeAllModals()
                $('.modal').modal('hide')
                $('.modal-backdrop').fadeOut(250, function() {
                    $('.modal-backdrop').remove()
                })
                $('body').removeClass('modal-open').css('padding-right', '0px');
                $('#oldInput').html('');
                $('#modalAjax').html('')
                removeLocationHash()
            })

            // form validation info
            $('.toast').toast('show')
        // })
    </script>

     {{--  Action Alert --}}
    <script type="application/javascript">
        @if($message = Session::get('alert-success'))
            Swal.fire({
                // position: 'top-end',
                type: 'success',
                title: '{{ $message }}',
                showConfirmButton: false,
                timer: 2000,
                toast: true
            })
        @elseif($message = Session::get('alert-warning'))
            Swal.fire({
                // position: 'top-end',
                type: 'warning',
                title: '{{ $message }}',
                showConfirmButton: false,
                timer: 2000,
                toast: true
            })
        @elseif($message = Session::get('alert-danger'))
            Swal.fire({
                // position: 'top-end',
                type: 'success',
                title: '{{ $message }}',
                showConfirmButton: false,
                timer: 2000,
                toast: true
            })
        @endif

        // Close action alert
        $(document).ready(function() {
            // show the alert
            setTimeout(function() {
                $(".action-alert").alert('close');
            }, 2000);
        });

        function ajaxActionAlert(type, message) {
            switch (type) {
                case 'success':
                    Swal.fire({
                        // position: 'top-end',
                        type: 'success',
                        title: message,
                        showConfirmButton: false,
                        timer: 2000,
                        toast: true
                    })
                    break;
                case 'warning':
                    Swal.fire({
                        // position: 'top-end',
                        type: 'warning',
                        title: message,
                        showConfirmButton: false,
                        timer: 2000,
                        toast: true
                    })
                    break;
                case 'danger':
                    Swal.fire({
                        // position: 'top-end',
                        type: 'danger',
                        title: message,
                        showConfirmButton: false,
                        timer: 2000,
                        toast: true
                    })
                    break;
                default:
                    break;
            }

        }
    </script>
    @yield('scripts')
</body>
</html>
