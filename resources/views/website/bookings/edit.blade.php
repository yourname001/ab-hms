<form action="{{ route('client_bookings.update', $booking->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="modal fase" id="editBooking" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog {{-- modal-dialog-centered  --}}modal-md" role="document">
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
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" class="form-control" name="book_date" id="bookDate" value="{{ $booking->booking_date_from .' - '. $booking->booking_date_to }}">
                                {{-- <div class="input-group datetimepickers" id="bookingTime" data-target-input="nearest">
                                    <input type="text" name="booking_time" class="form-control datetimepicker-input" data-toggle="datetimepicker" required autocomplete="off"/>
                                    <div class="input-group-append" data-target="#bookingTime" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="form-group">
                                <label>Room Type</label>
                                <select name="room_type" id="roomType" id="" class="form-control select2" required style="width: 100%">
                                    <option></option>
                                    @foreach ($room_types as $room_type)
                                        <option value="{{ $room_type->id }}" @if($booking->room->room_type_id == $room_type->id) selected @endif>{{ $room_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Room</label>
                                <select name="room" id="rooms" class="form-control select2" required style="width: 100%">
                                    {{-- <option></option>
                                    @foreach ($booking->room->room_type->roomTypeRooms as $room)
                                        <option value="{{ $room->id }}">
                                            {{ $room->name }}
                                        </option>
                                    @endforeach --}}
                                </select>
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

    filterRooms()
    function filterRooms() {
        var base_url = '{{ URL::to('') }}';
        var roomTypeID = $('#roomType').val();
        $.ajax({
            type:'POST',
            url: base_url+'/filter_rooms',
            data: {
                book_date: $('#bookDate').val(),
                room_type: roomTypeID,
                room_id: '{{ $booking->room_id }}',
                booking_id: '{{ $booking->id }}',
            },
            success:function(data){
                $('#rooms').html(data.room_options);
            },
            error:function (data){
                console.log('error')
            }
        });
    }
    
    $('#roomType').on('change', function(){
        filterRooms()
    });

    $(function(){
        $('input[name="book_date"]').daterangepicker({
            // timePicker: true,
            startDate: '{{ $booking->booking_date_from }}',
            endDate: '{{ $booking->booking_date_to }}',
            minDate: "{{ date('Y-m-d h:i A') }}",
            // endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'Y/M/DD'
            }
        });

        // Clear room type and rooms when date is changed
        $('input[name="book_date"]').change(function(){
            $("#roomType").val('').trigger('change')
            $('#rooms').html('<option></option>');
            $('#rooms').select2({
                placeholder: "Select",
            });
            $("#rooms").val('').trigger('change')
        })
    })
</script>