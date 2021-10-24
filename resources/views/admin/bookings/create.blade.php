@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('website/plugins/daterangepicker/daterangepicker.css') }}">
@endsection
@section('content')
<form method="POST" action="{{ route("admin.bookings.store") }}" enctype="multipart/form-data">
@csrf
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.booking.title_singular') }}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="client">Client</label>
                        <select class="form-control select2 {{ $errors->has('client') ? 'is-invalid' : '' }}" name="client">
                            <option></option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">
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
                        <label class="required" for="room_id">Room Type</label>
                        <select class="form-control select2" id="roomType" name="room_type">
                            <option></option>
                            @foreach($room_types as $room_type)
                                <option value="{{ $room_type->id }}">{{ $room_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="required" for="rooms">{{ trans('cruds.booking.fields.room') }}</label>
                        <select class="form-control select2 {{ $errors->has('room') ? 'is-invalid' : '' }}" name="room" id="rooms" required>
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
                    <div class="form-group">
                        <label class="required" for="booking_date">Date</label>
                        <input type="text" class="form-control" name="book_date" id="bookDate">
                        @if($errors->has('book_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('book_date') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.booking.fields.booking_date_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="roomInfo" style="display: none">
                        <legend>Room Info:</legend>
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
        <div class="card-footer">
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
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
    $('#roomType').on('change', function(){
        var base_url = '{{ URL::to('') }}';
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
                $('#roomInfo').fadeOut()
            },
            error:function (data){
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
                $('#roomAmount').html('₱ ' + data.room.amount)
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
                format: 'Y-M-DD'
            }
        });
    })
</script>
@endsection