@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <h1>{{ trans('panel.site_title') }}</h1>

                <p class="text-muted">{{ trans('global.login') }}</p>

                {{-- @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif --}}
                
                <form id="login-form">
                    @csrf
                    <div class="form-group">
                        <span class="text-danger" id="error-msg"></span>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>
                        <input id="email" name="email" type="text" class="form-control" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>
                        <input id="password" name="password" type="password" class="form-control" required placeholder="{{ trans('global.login_password') }}">
                    </div>
                    {{-- <div class="input-group mb-4">
                        <div class="form-check checkbox">
                            <input class="form-check-input" name="remember" type="checkbox" id="remember" style="vertical-align: middle;" />
                            <label class="form-check-label" for="remember" style="vertical-align: middle;">
                                {{ trans('global.remember_me') }}
                            </label>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-6">
                            <button id="submit-button" type="submit" class="btn btn-primary px-4">
                                {{ trans('global.login') }}
                            </button>
                        </div>
                        <div class="col-6 text-right">
                            @if(Route::has('password.request'))
                                <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                    {{ trans('global.forgot_password') }}
                                </a><br>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    // alert('asdasd')
    $(function(){
        $('#login-form').on('submit', function(e){
            // $('#submit-button').prop('disabled', true).append(' <i class="fa fa-spinner fa-spin fa-pulse"></i>')
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#error-msg").html("");
            var appURL = '{{ config("app.url") }}'
            $.ajax({
                type:'POST',
                url: appURL+'/login',
                data: {
                    email: $('#email').val(),
                    password: $('#password').val()
                },
                success:function(response) {
                    if(response.error_msg){
                        $("#error-msg").html(response.error_msg);
                        $('#submit-button').prop('disabled', false).html('Login')
                    }
                    if(response.redirect){
                        window.location.href = response.redirect;
                    }
                }
            });
        });
    })
</script>
@endsection