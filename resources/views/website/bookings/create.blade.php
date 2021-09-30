<form action="{{ route('client_bookings.store') }}" method="POST" autocomplete="off">
    @csrf
    <div class="modal fase" id="addBooking" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <input type="text" class="form-control" name="book_date" id="bookDate" {{-- value="{{ $book_date }}" --}}>
                                {{-- <div class="input-group datetimepickers" id="bookingTime" data-target-input="nearest">
                                    <input type="text" name="booking_time" class="form-control datetimepicker-input" data-toggle="datetimepicker" required autocomplete="off"/>
                                    <div class="input-group-append" data-target="#bookingTime" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="form-group">
                                <label>Room Type</label>
                                <select name="room_type" id="roomType" id="" class="form-control select2" required>
                                    <option></option>
                                    @foreach ($room_types as $room_type)
                                        <option value="{{ $room_type->id }}">{{ $room_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Room</label>
                                <select name="room" id="rooms" class="form-control select2" required>
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

    $(function(){
        $('input[name="book_date"]').daterangepicker({
            // timePicker: true,
            startDate: '{{ $date_from }}',
            endDate: '{{ $date_to }}',
            minDate: "{{ date('Y-m-d h:i A') }}",
            // endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'Y-M-DD'
            }
        });
    })
</script>