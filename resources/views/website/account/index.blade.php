@extends('layouts.website')
@section('content')
<div class="hero-wrap" style="background-image: url('{{ asset('website/images/bg_1.jpg') }}');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center d-flex align-items-end justify-content-center">
                <div class="text">
                    {{-- <p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.html">Home</a></span> <span>About</span></p> --}}
                    <h1 class="mb-4 bread">Account</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="ftco-section ftc-no-pb ftc-no-pt">
    <div class="container">
        <form action="{{ url('client/account/update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 py-5 wrap-about pb-md-5">
                    <legend>Profile Picture</legend>
                    <div class="row">
                        <div class="form-group col-md-7">
                            <img id="img" width="100%" class="img-thumbnail" style="border: none; background-color: transparent" src="{{ is_null($user->image) ? asset('images/image-icon.png') : asset('images/user/'.$user->image) }}" />
                            <label class="btn btn-primary btn-block">
                                Browse&hellip;<input value="" type="file" name="image" style="display: none;" id="upload" accept="image/png, image/jpeg" />
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 py-5 wrap-about pb-md-5">
                    <legend>Change Password</legend>
                    <div class="form-group">
                        <label for="old_password">Old Password</label>
                        <input id="old_password" name="old_password" type="password" class="form-control {{ $errors->has('old_password') ? 'is-invalid' : '' }}" requred>
                        @if($errors->has('old_password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('old_password') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input id="new_password" name="new_password" type="password" class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}" requred>
                        @if($errors->has('new_password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('new_password') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input id="new_password_confirmation" name="new_password_confirmation" type="password" class="form-control {{ $errors->has('new_password_confirmation') ? 'is-invalid' : '' }}" requred>
                        @if($errors->has('new_password_confirmation'))
                            <div class="invalid-feedback">
                                {{ $errors->first('new_password_confirmation') }}
                            </div>
                        @endif
                    </div>
                    {{-- <div class="heading-section heading-section-wo-line pt-md-5 mb-5">
                        <div class="ml-md-0">
                            <span class="subheading">Welcome to Qatara Family Resort</span>
                            <h5 class="mb-4">Welcome To Our Hotel</h5>
                        </div>
                    </div>
                    <div class="pb-md-5">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nascetur ridiculus mus mauris vitae ultricies leo integer. Pellentesque id nibh tortor id. Scelerisque varius morbi enim nunc faucibus a pellentesque. Id velit ut tortor pretium viverra. Sit amet mattis vulputate enim nulla aliquet. Dui accumsan sit amet nulla facilisi morbi tempus. Tellus cras adipiscing enim eu turpis. At imperdiet dui accumsan sit amet nulla facilisi. Arcu bibendum at varius vel pharetra vel turpis. Purus in mollis nunc sed. Varius sit amet mattis vulputate enim.</p>
                        <p>Phasellus faucibus scelerisque eleifend donec pretium vulputate sapien. Elit sed vulputate mi sit amet mauris commodo quis imperdiet. Lacus viverra vitae congue eu consequat ac. Quisque id diam vel quam elementum pulvinar etiam. Nulla facilisi cras fermentum odio eu feugiat pretium nibh. Velit egestas dui id ornare arcu odio ut sem. Elit ut aliquam purus sit amet luctus venenatis lectus. Orci ac auctor augue mauris. Fermentum odio eu feugiat pretium nibh ipsum consequat nisl vel. Velit euismod in pellentesque massa. Urna porttitor rhoncus dolor purus non enim praesent. Laoreet suspendisse interdum consectetur libero id faucibus nisl tincidunt eget. Tristique senectus et netus et. Nunc congue nisi vitae suscipit tellus mauris a diam maecenas. Quisque id diam vel quam elementum pulvinar etiam non. Malesuada fames ac turpis egestas sed tempus urna et pharetra. Risus ultricies tristique nulla aliquet enim.</p>
                    </div> --}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right mb-5">
                    <button class="btn btn-primary text-right">Save</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
@section('scripts')
    <script>
        $(function(){
            $('#upload').change(function(){
                var input = this;
                var url = $(this).val();
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
                {
                    var reader = new FileReader();
                    
                    reader.onload = function (e) {
                        $('#img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
        });
    </script>
@endsection