<form action="{{ route('client_bookings.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="addBooking" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Booking</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            {{-- <strong class="text-danger">Business hours is from 8:00AM to 5:00PM</strong> --}}
                            <div class="form-group">
                                <label>Booking Date (Check in/Check out date)</label>
                                <input type="text" class="form-control" name="book_date" id="bookDate" {{-- value="{{ $book_date }}" --}}>
                            </div>
                            <div class="form-group">
                                <label>Room Type</label>
                                <select name="room_type" id="roomType" class="form-control select2" required style="width: 100%">
                                    <option></option>
                                    @foreach ($room_types as $room_type)
                                        <option value="{{ $room_type->id }}">{{ $room_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Room</label>
                                <select name="room" id="rooms" class="form-control select2" required style="width: 100%">
                                    <option></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Proof of Identity</label>
                                <select name="type_of_identification" class="form-control select2" required style="width: 100%">
                                    <option></option>
                                    <option value="Valid Driver's License">Valid Driver's License</option>
                                    <option value="State-issued Identification Card">State-issued Identification Card</option>
                                    <option value="Student Identification Card">Student Identification Card</option>
                                    <option value="Social Security Card">Social Security Card</option>
                                    <option value="Military Identification Card">Military Identification Card</option>
                                    <option value="Passport">Passport</option>
                                </select>
                                <div class="row justify-content-center">
                                    <div class="form-group col-md-6">
                                        <img id="img" width="100%" class="img-thumbnail" style="border: none; background-color: transparent" src="{{ asset('images/image-icon.png') }}" />
                                        <label class="btn btn-primary btn-block">
                                            Browse&hellip;<input value="" type="file" name="proof_of_identity" style="display: none;" id="upload" accept="image/png, image/jpeg" required/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <legend>Room Info:</legend>
                            <div id="roomInfo" style="display: none">
                                <div class="form-group">
                                    <img class="img-thumbnail" src="" alt="" id="roomImage">
                                </div>
                                <div class="form-group">
                                    <label for="">Name:</label>
                                    <span id="roomName"></span>
                                </div>
                                <div class="form-group">
                                    <label for="">Description:</label>
                                    <span id="roomDescription"></span>
                                </div>
                                <div class="form-group">
                                    <label for="">Amount:</label>
                                    <span id="roomAmount"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal-ajax">Cancel</button>
                    <button class="btn btn-default text-success" type="submit"><i class="fas fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var base_url = '{{ URL::to('') }}';
    $('#roomType').on('change', function(){
        var id = $(this).val();
        $.ajax({
            type:'POST',
            url: base_url+'/filter_rooms',
            data: {
                book_date: $('#bookDate').val(),
                room_type: id,
            },
            success:function(data){
                $('#rooms').html(data.room_options);
            },
            error:function (data){
                console.log('error')
                /* Swal.fire({
                    // position: 'top-end',
                    type: 'error',
                    title: 'error',
                    showConfirmButton: false,
                    toast: true
                }); */
            }
        });
    });

    // Room Info
    $('#rooms').on('change', function(){
        var base_url = '{{ URL::to('') }}';
        var id = $(this).val();
        $.ajax({
            type:'GET',
            url: base_url+'/get_room_info/' + id,
            /* data: {
                room_id: id
            }, */
            success:function(data){
                $('#roomImage').attr('src', data.room_image);
                $('#roomName').html(data.room.name)
                $('#roomDescription').html(data.room.description)
                $('#roomAmount').html('₱ ' + data.room.amount + "/night")
                $('#roomInfo').fadeIn()
            },
            error:function (data){
                console.log('error')
                Swal.fire({
                    // position: 'top-end',
                    type: 'error',
                    title: 'error',
                    showConfirmButton: false,
                    toast: true
                });
            }
        });
    });

    $(function(){
        $('input[name="book_date"]').daterangepicker({
            // timePicker: true,
            startDate: '{{ $date_from }}',
            endDate: '{{ $date_to }}',
            minDate: "{{ date('Y/m/d h:i A') }}",
            // endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'Y/M/DD'
            }
        });

        $('.drp-calendar .right').find('.calendar-time').fadeOut();

        // Clear room type, rooms, and room info when date is changed
        $('input[name="book_date"]').change(function(){
            $('#roomInfo').fadeOut();
            $("#roomType").val('').trigger('change')
            $('#rooms').html('<option></option>');
            $('#rooms').select2({
                placeholder: "Select",
            });
            $("#rooms").val('')
        })
    })

    // Image upload
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