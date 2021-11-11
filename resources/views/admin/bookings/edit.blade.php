@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('website/plugins/daterangepicker/daterangepicker.css') }}">
@endsection
@section('content')
<form method="POST" action="{{ route("admin.bookings.store") }}" enctype="multipart/form-data">
@csrf
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.booking.title_singular') }}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="client">Client</label>
                        <select class="form-control select2 {{ $errors->has('client') ? 'is-invalid' : '' }}" name="client">
                            <option></option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" @if($booking->user_id == $client->id) selected @endif>
                                    {{ $client->first_name }}
                                    {{ $client->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('client'))
                            <div class="invalid-feedback">
                                {{ $errors->first('room_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="required" for="booking_date">Date</label>
                        <input type="text" class="form-control" name="book_date" id="bookDate" value="{{ $booking->booking_date_from .' - '. $booking->booking_date_to }}">
                        @if($errors->has('book_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('book_date') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.booking.fields.booking_date_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="room_id">Room Type</label>
                        <select class="form-control select2" id="roomType" name="room_type" style="width: 100%">
                            <option></option>
                            @foreach($room_types as $room_type)
                                <option value="{{ $room_type->id }}" @if($booking->room->room_type_id == $room_type->id) selected @endif>{{ $room_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="required" for="rooms">{{ trans('cruds.booking.fields.room') }}</label>
                        <select class="form-control select2 {{ $errors->has('room') ? 'is-invalid' : '' }}" name="room" id="rooms" required style="width: 100%">
                            {{-- @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id') == $id ? 'selected' : '' }}>{{ $room->name }}</option>
                            @endforeach --}}
                        </select>
                        @if($errors->has('room'))
                            <div class="invalid-feedback">
                                {{ $errors->first('room') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.booking.fields.room_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="roomInfo">
                        <legend>Room Info:</legend>
                        <div class="form-group">
                            <img class="img-thumbnail" src="{{ asset($booking->room->roomImage()) }}" alt="" id="roomImage">
                        </div>
                        <div class="form-group">
                            <label for="">Name:</label>
                            <span id="roomName">{{ $booking->room->name }}</span>
                        </div>
                        <div class="form-group">
                            <label for="">Description:</label>
                            <span id="roomDescription">{{ $booking->room->description }}</span>
                        </div>
                        <div class="form-group">
                            <label for="">Amount:</label>
                            <span id="roomAmount">{{ number_format($booking->room->amount, 2) }}/night</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="form-group">
                <a class="btn btn-danger" href="{{ route('admin.bookings.index') }}">
                    Cancel
                </a>
                <button class="btn btn-success" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
@section('scripts')
<script src="{{ asset('website/plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('website/plugins/daterangepicker/daterangepicker.js') }}"></script>
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
        $('#bookDate').daterangepicker({
            // timePicker: true,
            minDate: "{{ date('Y-m-d h:i A') }}",
            // endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'Y/M/DD'
            }
        });

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
</script>
@endsection