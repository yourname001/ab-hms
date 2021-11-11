@extends('layouts.website')
@section('content')

<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image:url({{ asset('images/banner/banner-1.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-12 ftco-animate text-center">
            <div class="text mb-5 pb-3">
                <h1 class="mb-3">Qatara Family Resort</h1>
                <h2>Hotels &amp; Resorts</h2>
            </div>
        </div>
        </div>
        </div>
    </div>

    <div class="slider-item" style="background-image:url({{ asset('images/banner/banner-2.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-12 ftco-animate text-center">
            <div class="text mb-5 pb-3">
                <h1 class="mb-3">Pearl of Qatara Alaminos</h1>
                <h2>Join With Us</h2>
            </div>
        </div>
        </div>
        </div>
    </div>
</section>
@auth
@if(is_null(Auth::user()->email_verified_at))
<div style="margin-bottom: 100px" id="verify-email"></div>
<section class="ftco-section mt-5 ftc-no-pb ftc-no-pt">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <h4>Email not Verified</h4>
                    <h5>You must verify your email first. If the email verification is expired, click <a class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('verificationEmail').submit();">here</a></h5>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endauth
<section class="ftco-section ftc-no-pb ftc-no-pt">
    <div class="container">
        <div class="row">
            {{-- <div class="col-md-5 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url(images/bg_2.jpg);">
                <a href="https://vimeo.com/45830194" class="icon popup-vimeo d-flex justify-content-center align-items-center">
                    <span class="icon-play"></span>
                </a>
            </div> --}}
            <div class="col-md-12 py-5 wrap-about pb-md-5 ftco-animate">
                <div class="heading-section heading-section-wo-line pt-md-5 mb-5">
                    <div class="ml-md-0">
                        <span class="subheading">Welcome to Qatara Family Resort</span>
                        <h2 class="mb-4">Welcome To Our Hotel</h2>
                    </div>
                </div>
                <div class="pb-md-5">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nascetur ridiculus mus mauris vitae ultricies leo integer. Pellentesque id nibh tortor id. Scelerisque varius morbi enim nunc faucibus a pellentesque. Id velit ut tortor pretium viverra. Sit amet mattis vulputate enim nulla aliquet. Dui accumsan sit amet nulla facilisi morbi tempus. Tellus cras adipiscing enim eu turpis. At imperdiet dui accumsan sit amet nulla facilisi. Arcu bibendum at varius vel pharetra vel turpis. Purus in mollis nunc sed. Varius sit amet mattis vulputate enim.</p>
                    <p>Phasellus faucibus scelerisque eleifend donec pretium vulputate sapien. Elit sed vulputate mi sit amet mauris commodo quis imperdiet. Lacus viverra vitae congue eu consequat ac. Quisque id diam vel quam elementum pulvinar etiam. Nulla facilisi cras fermentum odio eu feugiat pretium nibh. Velit egestas dui id ornare arcu odio ut sem. Elit ut aliquam purus sit amet luctus venenatis lectus. Orci ac auctor augue mauris. Fermentum odio eu feugiat pretium nibh ipsum consequat nisl vel. Velit euismod in pellentesque massa. Urna porttitor rhoncus dolor purus non enim praesent. Laoreet suspendisse interdum consectetur libero id faucibus nisl tincidunt eget. Tristique senectus et netus et. Nunc congue nisi vitae suscipit tellus mauris a diam maecenas. Quisque id diam vel quam elementum pulvinar etiam non. Malesuada fames ac turpis egestas sed tempus urna et pharetra. Risus ultricies tristique nulla aliquet enim.</p>
                    <ul class="ftco-social d-flex">
                        {{-- <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li> --}}
                        <li class="ftco-animate"><a href="https://www.facebook.com/PearlofQatarAlaminos" target="_blank"><span class="icon-facebook"></span></a></li>
                        {{-- <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li> --}}
                        {{-- <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li> --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Featured Rooms --}}
@if($featuredRooms->count() > 0)
<section class="ftco-section bg-light">
    <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
      <div class="col-md-7 heading-section text-center ftco-animate">
        <h2 class="mb-4">Our Rooms</h2>
      </div>
    </div>    		
        <div class="row">
            @foreach ($featuredRooms as $room)
            <div class="col-sm col-md-6 col-lg-4 ftco-animate">
                <div class="room">
                    <a href="javascript:void(0)" class="img d-flex justify-content-center align-items-center" style="background-image: url({{ asset('images/rooms/'.$room->image) }});">
                        {{-- <div class="icon d-flex justify-content-center align-items-center">
                            <span class="icon-search2"></span>
                        </div> --}}
                    </a>
                    <div class="text p-3 text-center">
                        <h3 class="mb-3"><a href="rooms.html">{{ $room->room_type->name }}</a></h3>
                        <p><span class="price mr-2">₱{{ number_format($room->amount, 2) }}</span> <span class="per">per night</span></p>
                        {{-- <hr>
                        <p class="pt-1"><a href="room-single.html" class="btn-custom">View Room Details <span class="icon-long-arrow-right"></span></a></p> --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection