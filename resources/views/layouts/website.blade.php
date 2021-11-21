<!DOCTYPE html>
<html lang="en">
<head>
    <title>Qatara Family Resort</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i" rel="stylesheet">

    {{-- <link rel="stylesheet" href="{{ asset('bootstrap-4.3.1/css/bootstrap.min.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('website/css/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('website/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/animate.css') }}">
    
    <link rel="stylesheet" href="{{ asset('website/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('website/css/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('website/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('website/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/jquery.timepicker.css') }}">

    <link rel="stylesheet" href="{{ asset('website/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/plugins/sweetalert2/sweetalert2.min.css') }}">

    
    <link rel="stylesheet" href="{{ asset('website/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/style.css') }}">

    {{-- fontawesome --}}
    <link rel="stylesheet" href="{{ asset('webfonts/fontawesome-pro-5.12.0-web/css/all.min.css') }}">

    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('website/img/favicon.png') }}"> --}}

    @yield('style')

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="/">Qatara Family Resort</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="/" class="nav-link">Home</a></li>
                    @auth
                    @if (!is_null(Auth::user()->email_verified_at))
                    <li class="nav-item"><a href="{{ route('client_bookings.index') }}" class="nav-link">Booking</a></li>
                    @endif
                    @endauth
                    {{-- <li class="nav-item"><a href="restaurant.html" class="nav-link">Restaurant</a></li> --}}
                    {{-- <li class="nav-item"><a href="#" class="nav-link">About</a></li> --}}
                    {{-- <li class="nav-item"><a href="blog.html" class="nav-link">Blog</a></li> --}}
                    {{-- <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li> --}}
                    @auth
                    @if(!is_null(Auth::user()->email_verified_at))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" href="#" id="accountMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->first_name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="accountMenu">
                            <a class="dropdown-item" href="{{ route('client.account', Auth::user()->id) }}">Account</a>
                            <a class="dropdown-item" href="#logout" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">Logout</a>
                        </div>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="#verify-email" class="nav-link badge badge-warning">Email not verified</a>
                    </li>
                    @endif
                    {{-- <li class="nav-item"><a href="javascript:void(0)" data-toggle="modal-ajax" data-target="login" data-href="{{ route('client.login') }}" class="nav-link">{{ Auth::user()->first_name }}</a></li> --}}
                    @else
                    <li class="nav-item"><a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#login" data-href="{{ route('client.login') }}" class="nav-link">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    @yield('content')

    <footer class="ftco-footer ftco-bg-dark ftco-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Deluxe Hotel</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                        {{-- <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li> --}}
                        <li class="ftco-animate"><a href="https://www.facebook.com/PearlofQatarAlaminos" target="_blank"><span class="icon-facebook"></span></a></li>
                        {{-- <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li> --}}
                        </ul>
                    </div>
                </div>
                {{-- <div class="col-md">
                    <div class="ftco-footer-widget mb-4 ml-md-5">
                        <h2 class="ftco-heading-2">Useful Links</h2>
                        <ul class="list-unstyled">
                        <li><a href="#" class="py-2 d-block">Blog</a></li>
                        <li><a href="#" class="py-2 d-block">Rooms</a></li>
                        <li><a href="#" class="py-2 d-block">Amenities</a></li>
                        <li><a href="#" class="py-2 d-block">Gift Card</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Privacy</h2>
                        <ul class="list-unstyled">
                        <li><a href="#" class="py-2 d-block">Career</a></li>
                        <li><a href="#" class="py-2 d-block">About Us</a></li>
                        <li><a href="#" class="py-2 d-block">Contact Us</a></li>
                        <li><a href="#" class="py-2 d-block">Services</a></li>
                        </ul>
                    </div>
                </div> --}}
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Have a Questions?</h2>
                        <div class="block-23 mb-3">
                            <ul>
                            <li><span class="icon icon-map-marker"></span><span class="text">069 Brgy. Magsaysay, Alaminos City, Pangasinan, Philippines</span></li>
                            <li><a href="#"><span class="icon icon-phone"></span><span class="text">+639206934160</span></a></li>
                            <li><a href="#"><span class="icon icon-envelope"></span><span class="text">qatarafamilyresort.69@gmail.com </span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | <i class="icon-heart color-danger" aria-hidden="true"></i> <a href="/">Qatara Family Resort</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    @auth
    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    <form id="verificationEmail" action="{{ url('/email/verification-notification') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    @endauth

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
        {{-- <div style="position: absolute; top: 0; right: 0; z-index: 1111">
            <div class="toast" data-autohide="false" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="mr-auto text-danger">Whoops!</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                </div>
                <div class="toast-body">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div> --}}
        <div class="modal fade" id="formValidationError" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="DoctorsNotes" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title text-danger"><i class="fad fa-exclamation-triangle"></i> Error</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer text-right">
                        <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                    </div>
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
      
    
  
    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
  
  
    <script src="{{ asset('website/js/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('website/js/jquery-3.2.1.min.js') }}"></script> --}}
    <script src="{{ asset('website/js/jquery-migrate-3.0.1.min.js') }}"></script>
    {{-- <script src="{{ asset('bootstrap-4.3.1/js/bootstrap.bundle.min.js') }}"></script> --}}
    <script src="{{ asset('website/js/popper.min.js') }}"></script>
    <script src="{{ asset('website/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('website/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('website/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('website/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('website/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('website/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('website/js/aos.js') }}"></script>
    <script src="{{ asset('website/js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('website/js/bootstrap-datepicker.js') }}"></script>
    {{-- <script src="{{ asset('website/js/jquery.timepicker.min.js') }}"></script> --}}
    <script src="{{ asset('website/js/scrollax.min.js') }}"></script>
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script> --}}
    {{-- <script src="{{ asset('website/js/google-map.js') }}"></script> --}}
    <script src="{{ asset('website/js/main.js') }}"></script>

    @include('partials.scripts')
    @yield('scripts')

    {{-- Backdrop for dual modal --}}
    <script>
        $(document).on('show.bs.modal', '.modal', function () {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });
    </script>
    </body>
  </html>