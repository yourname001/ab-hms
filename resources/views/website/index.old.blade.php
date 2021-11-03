@extends('layouts.website')
@section('content')
<!-- slider_area_start -->
<div class="slider_area">
    <div class="slider_active owl-carousel">
        @auth
        @if(is_null(Auth::user()->email_verified_at))
        <div class="single_slider d-flex align-items-center justify-content-center slider_bg_1">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="slider_text text-center">
                            @if (session('message'))
                                <div class="alert alert-success">
                                    <h4>{{ session('message') }}</h4>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <h4>Email not Verified</h4>
                                    <h5>You must verify your email first. If your email verification is expired, click <a class="link-button-sm" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('verificationEmail').submit();">here</a></h5>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="single_slider d-flex align-items-center justify-content-center slider_bg_1">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="slider_text text-center">
                            <h3>Qatara Family Resort</h3>
                            {{-- <p>Unlock to enjoy the view of Martine</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single_slider  d-flex align-items-center justify-content-center slider_bg_2">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="slider_text text-center">
                            {{-- <h3>Life is Beautiful</h3> --}}
                            {{-- <p>Unlock to enjoy the view of Martine</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single_slider  d-flex align-items-center justify-content-center slider_bg_3">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="slider_text text-center">
                            {{-- <h3>Life is Beautiful</h3> --}}
                            {{-- <p>Unlock to enjoy the view of Martine</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single_slider  d-flex align-items-center justify-content-center slider_bg_4">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="slider_text text-center">
                            {{-- <h3>Life is Beautiful</h3> --}}
                            {{-- <p>Unlock to enjoy the view of Martine</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endauth
        @guest
        <div class="single_slider d-flex align-items-center justify-content-center slider_bg_1">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="slider_text text-center">
                            <h3>Qatara Family Resort</h3>
                            {{-- <p>Unlock to enjoy the view of Martine</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single_slider  d-flex align-items-center justify-content-center slider_bg_2">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="slider_text text-center">
                            {{-- <h3>Life is Beautiful</h3> --}}
                            {{-- <p>Unlock to enjoy the view of Martine</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single_slider  d-flex align-items-center justify-content-center slider_bg_3">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="slider_text text-center">
                            {{-- <h3>Life is Beautiful</h3> --}}
                            {{-- <p>Unlock to enjoy the view of Martine</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single_slider  d-flex align-items-center justify-content-center slider_bg_4">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="slider_text text-center">
                            {{-- <h3>Life is Beautiful</h3> --}}
                            {{-- <p>Unlock to enjoy the view of Martine</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endguest
    </div>
</div>
{{-- <div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col text-center">
            <div class="card">
                <div class="card-body">
                    <p>
                        
                    </p>
                    Resend Veryfication Email</a>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<!-- slider_area_end -->

<!-- about_area_start -->
{{-- <div class="about_area">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-5">
                <div class="about_info">
                    <div class="section_title mb-20px">
                        <span>About Us</span>
                        <h3>A Luxuries Hotel <br>
                            with Nature</h3>
                    </div>
                    <p>Suscipit libero pretium nullam potenti. Interdum, blandit phasellus consectetuer dolor ornare
                        dapibus enim ut tincidunt rhoncus tellus sollicitudin pede nam maecenas, dolor sem. Neque
                        sollicitudin enim. Dapibus lorem feugiat facilisi faucibus et. Rhoncus.</p>
                    <a href="#" class="line-button">Learn More</a>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7">
                <div class="about_thumb d-flex">
                    <div class="img_1">
                        <img src="{{ asset('website/img/about/about_1.png') }}" alt="">
                    </div>
                    <div class="img_2">
                        <img src="{{ asset('website/img/about/about_2.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- about_area_end -->

<!-- offers_area_start -->
{{-- <div class="offers_area">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section_title text-center mb-100">
                    <span>Our Offers</span>
                    <h3>Ongoing Offers</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-md-4">
                <div class="single_offers">
                    <div class="about_thumb">
                        <img src="{{ asset('website/img/offers/1.png') }}" alt="">
                    </div>
                    <h3>Up to 35% savings on Club <br>
                        rooms and Suites</h3>
                    <ul>
                        <li>Luxaries condition</li>
                        <li>3 Adults & 2 Children size</li>
                        <li>Sea view side</li>
                    </ul>
                    <a href="#" class="book_now">book now</a>
                </div>
            </div>
            <div class="col-xl-4 col-md-4">
                <div class="single_offers">
                    <div class="about_thumb">
                        <img src="{{ asset('website/img/offers/2.png') }}" alt="">
                    </div>
                    <h3>Up to 35% savings on Club <br>
                        rooms and Suites</h3>
                    <ul>
                        <li>Luxaries condition</li>
                        <li>3 Adults & 2 Children size</li>
                        <li>Sea view side</li>
                    </ul>
                    <a href="#" class="book_now">book now</a>
                </div>
            </div>
            <div class="col-xl-4 col-md-4">
                <div class="single_offers">
                    <div class="about_thumb">
                        <img src="{{ asset('website/img/offers/3.png') }}" alt="">
                    </div>
                    <h3>Up to 35% savings on Club <br>
                        rooms and Suites</h3>
                    <ul>
                        <li>Luxaries condition</li>
                        <li>3 Adults & 2 Children size</li>
                        <li>Sea view side</li>
                    </ul>
                    <a href="#" class="book_now">book now</a>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- offers_area_end -->

<!-- video_area_start -->
{{-- <div class="video_area video_bg overlay">
    <div class="video_area_inner text-center">
        <span>Montana Sea View</span>
        <h3>Relax and Enjoy your <br>
            Vacation </h3>
        <a href="https://www.youtube.com/watch?v=vLnPwxZdW4Y" class="video_btn popup-video">
            <i class="fa fa-play"></i>
        </a>
    </div>
</div> --}}
<!-- video_area_end -->

<!-- about_area_start -->
<div class="about_area">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-7">
                <div class="about_thumb2 d-flex">
                    <div class="img_1">
                        <img src="{{ asset('images/food-1.jpg') }}" alt="">
                    </div>
                    <div class="img_2">
                        <img src="{{ asset('images/food-2.jpg') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5">
                <div class="about_info">
                    <div class="section_title mb-20px">
                        <span>Delicious Food</span>
                        <h3>We Serve Fresh and <br>
                            Delicious Food</h3>
                    </div>
                    <p>Suscipit libero pretium nullam potenti. Interdum, blandit phasellus consectetuer dolor ornare
                        dapibus enim ut tincidunt rhoncus tellus sollicitudin pede nam maecenas, dolor sem. Neque
                        sollicitudin enim. Dapibus lorem feugiat facilisi faucibus et. Rhoncus.</p>
                    {{-- <a href="#" class="line-button">Learn More</a> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- about_area_end -->

<!-- features_room_startt -->
{{-- @if($featuredRooms->count() > 0)
<div class="features_room">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section_title text-center mb-100">
                    <span>Featured Rooms</span>
                    <h3>Choose a Better Room</h3>
                </div>
            </div>
        </div>
    </div>
    @foreach ($featuredRooms as $room)
    <div class="rooms_here">
        <div class="single_rooms">
            <div class="room_thumb">
                <img src="{{ asset('images/rooms/'.$room->image) }}" alt="">
                <div class="room_heading d-flex justify-content-between align-items-center">
                    <div class="room_heading_inner">
                        <span>From ₱{{ $room->amount }}/night</span>
                        <h3>{{ $room->room_type->name }}</h3>
                    </div>
                    <a href="#" class="line-button">book now</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif --}}
<!-- features_room_end -->

<!-- forQuery_start -->
{{-- <div class="forQuery">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 offset-xl-1 col-md-12">
                <div class="Query_border">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-xl-6 col-md-6">
                            <div class="Query_text">
                                <p>For Reservation 0r Query?</p>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="phone_num">
                                <a href="#" class="mobile_no">+10 576 377 4789</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- forQuery_end-->

<!-- instragram_area_start -->
{{-- <div class="instragram_area">
    <div class="single_instagram">
        <img src="{{ asset('website/img/instragram/1.png') }}" alt="">
        <div class="ovrelay">
            <a href="#">
                <i class="fa fa-instagram"></i>
            </a>
        </div>
    </div>
    <div class="single_instagram">
        <img src="{{ asset('website/img/instragram/2.png') }}" alt="">
        <div class="ovrelay">
            <a href="#">
                <i class="fa fa-instagram"></i>
            </a>
        </div>
    </div>
    <div class="single_instagram">
        <img src="{{ asset('website/img/instragram/3.png') }}" alt="">
        <div class="ovrelay">
            <a href="#">
                <i class="fa fa-instagram"></i>
            </a>
        </div>
    </div>
    <div class="single_instagram">
        <img src="{{ asset('website/img/instragram/4.png') }}" alt="">
        <div class="ovrelay">
            <a href="#">
                <i class="fa fa-instagram"></i>
            </a>
        </div>
    </div>
    <div class="single_instagram">
        <img src="{{ asset('website/img/instragram/5.png') }}" alt="">
        <div class="ovrelay">
            <a href="#">
                <i class="fa fa-instagram"></i>
            </a>
        </div>
    </div>
</div> --}}
<!-- instragram_area_end -->
@endsection