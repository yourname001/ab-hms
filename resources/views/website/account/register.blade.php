{{-- <form action="{{ route('register') }}" method="POST"> --}}
<form id="registration-form">
    @csrf
    <div class="modal" id="register" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog {{-- modal-dialog-centered  --}}modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Register</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input id="first_name" type="text" class="form-control" name="first_name" autocomplete="first_name" >
                                <span class="text-danger" id="first_name-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input id="last_name" type="text" class="form-control" name="last_name" autocomplete="last_name" >
                                <span class="text-danger" id="last_name-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="contact_number">Contact #</label>
                                <input id="contact_number" type="text" class="form-control" name="contact_number" autocomplete="contact_number" >
                                <span class="text-danger" id="contact_number-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" name="address" id="address" rows="3"></textarea>
                                <span class="text-danger" id="address-error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="email" autocomplete="email" >
                                <span class="text-danger" id="email-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password"  class="form-control" name="password" >
                                <span class="text-danger" id="password-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input id="password_confirmation" type="password"  class="form-control" name="password_confirmation" >
                                <span class="text-danger" id="password_confirmation-error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal-ajax">Cancel</button>
                    <button class="btn btn-default text-success" id="register-button" type="submit">Register</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(function(){
        $('#registration-form').on('submit', function(e){
            // $('#register-button').prop('disabled', true).append(' <i class="fa fa-spinner fa-spin fa-pulse"></i>')
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#first_name-error').html("");
            $('#last_name-error').html("");
            $('#contact_number-error').html("");
            $('#address-error').html("");
            $('#email-error').html("");
            $('#password-error').html("");
            $('#password_confirmation-error').html("");
            var appURL = '{{ config("app.url") }}'
            $.ajax({
                type:'POST',
                url: appURL + '/register',
                data: {
                    first_name: $('#first_name').val(),
                    last_name: $('#last_name').val(),
                    contact_number: $('#contact_number').val(),
                    address: $('#address').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    password_confirmation: $('#password_confirmation').val()
                },
                success:function(response) {
                    location.reload()
                },
                fail:function(response) {
                    console.log("Fail")
                    $('#register-button').prop('disabled', false).html('Register')
                },
                error:function(data) {
                    // console.log(data.responseJSON)
                    var errors = data.responseJSON.errors;
                    $.each(errors, function(index, value)
                    {
                        // console.log(index + " =>" + value)
                        if (value.length != 0)
                        {
                            $("#"+index+"-error").html(value);
                        }
                    });
                    $('#register-button').prop('disabled', false).html('Register')
                }
            });
        });
    })
</script>
