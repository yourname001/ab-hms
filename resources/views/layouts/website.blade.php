<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Qatara Family Resort</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('website/img/favicon.png') }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('website/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/style.css') }}">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
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
                                        <li><a class="active" href="{{ route('resort.index') }}">Home</a></li>
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
                                    <a class="popup-with-form" href="#book-form">Book A Room</a>
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

    {{-- book form --}}
    <form id="book-form" class="white-popup-block mfp-hide form-contact" autocomplete="off">
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
                            {{-- <select class="form-select wide" id="default-select" class="">
                                <option data-display="Adult">1</option>
                                <option value="1">2</option>
                                <option value="2">3</option>
                                <option value="3">4</option>
                            </select> --}}
                            <br>
                        </div>
                        {{-- <div class="col-xl-6">
                            <input class="form-control" type="number" placeholder="Children">
                            <select class="form-select wide" id="default-select" class="">
                                <option data-display="Children">1</option>
                                <option value="1">2</option>
                                <option value="2">3</option>
                                <option value="3">4</option>
                            </select>
                        </div> --}}
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

    @guest
    {{-- Login form --}}
    <form id="login-form" class="white-popup-block mfp-hide form-contact" autocomplete="off">
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

    <form class="white-popup-block mfp-hide form-contact" id="registration-form" method="POST" action="{{ route('register') }}" autocomplete="off">
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
                        <input id="registerEmail" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete>
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
                            <li><a href="#">Bookings</a></li>
                            <li><a href="#">Account Settings</a></li>
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
    <script src="{{ asset('website/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('website/js/popper.min.js') }}"></script>
    <script src="{{ asset('website/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('website/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('website/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('website/js/ajax-form.js') }}"></script>
    <script src="{{ asset('website/js/waypoints.min.js') }}"></script>
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
    @yield('scripts')
</body>
</html>
