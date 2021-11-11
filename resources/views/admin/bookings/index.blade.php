@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="{{ asset('website/plugins/daterangepicker/daterangepicker.css') }}">
    <style>
        .filter-data .form-group {
            margin-bottom: 0px
        }
    </style>
@endsection
@section('content')
@can('booking_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.bookings.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.booking.title_singular') }}
            </a>
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#filterOptions">
                Filter
            </button>
            <a class="btn btn-primary" href="{{ route("admin.bookings.print_report", [
                'book_date' => request()->get('book_date'),
                'clients' => request()->get('clients'),
                'room_type' => request()->get('room_type'),
                'room' => request()->get('room'),
                'booking_status' => request()->get('booking_status'),
                'payment_status' => request()->get('payment_status')
            ]) }}" target="_blank">
                Print Report
            </a>
        </div>
    </div>
@endcan
@if(request()->get('filter') == 1)
<div class="card">
    <div class="card-header">
        Filter
    </div>
    <div class="card-body filter-data">
        <div class="form-group">
            <label>Booking Date: </label>
            {{ request()->get('book_date') }}
        </div>
        <div class="form-group">
            <label>Clients: </label>
            @if(!is_null(request()->get('clients')))
                @forelse (request()->get('clients') as $client)
                    {{ App\Models\User::find($client)->name() }}@if(!$loop->last), @endif
                @empty
                @endforelse
            @endif
        </div>
        <div class="form-group">
            <label>Room Type:</label>
            {{ App\Models\RoomType::find(request()->get('room_type'))->name ?? "" }}
        </div>
        <div class="form-group">
            <label>Room:</label>
            {{ App\Models\Room::find(request()->get('room'))->name ?? "" }}
        </div>
        <div class="form-group">
            <label>Booking Status: </label>
            @if(!is_null(request()->get('booking_status')))
                @forelse (request()->get('booking_status') as $booking_status)
                    {{ $booking_status }}@if(!$loop->last), @endif
                @empty
                @endforelse
            @endif
        </div>
        <div class="form-group">
            <label>Payment Status: </label>
            @if(!is_null(request()->get('payment_status')))
                @forelse (request()->get('payment_status') as $payment_status)
                    {{ $payment_status }}@if(!$loop->last), @endif
                @empty
                @endforelse
            @endif
        </div>
    </div>
</div>
@endif
<div class="card">
    <div class="card-header">
        {{ trans('cruds.booking.title_singular') }} {{ trans('global.list') }}
    </div>
    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Booking">
            <thead>
                <tr>
                    <th width="10"></th>
                    <th>ID</th>
                    <th>Booking Status</th>
                    <th>Payment Status</th>
                    <th>Client Name</th>
                    <th>Room</th>
                    <th>Amount Paid</th>
                    <th>Balance</th>
                    <th>Amount</th>
                    <th>Booking Date From</th>
                    <th>Booking Date To</th>
                    <th></th>
                </tr>
            </thead>
            @if(request()->get('filter') == 1)
            <tbody>
                @forelse ($bookings as $booking)
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        {{ $booking->id }}
                    </td>
                    <td>
                        {!! $booking->getBookingStatus() !!}
                    </td>
                    <td>
                        {!! $booking->getPaymentStatus() !!}
                    </td>
                    <td>
                        {{ $booking->client->name() }}
                    </td>
                    <td>
                        {{ $booking->room->name }}
                    </td>
                    <td>
                        {{ $booking->payments->sum('amount') }}
                    </td>
                    <td>
                        {{ $booking->amount - $booking->payments->sum('amount') }}
                    </td>
                    <td>
                        {{ $booking->amount }}
                    </td>
                    <td>
                        {{ date('Y-m-d', strtotime($booking->booking_date_from)) }}
                    </td>
                    <td>
                        {{ date('Y-m-d', strtotime($booking->booking_date_to)) }}
                    </td>
                    <td>
                        {{ view('partials.datatablesActions', [
                            'viewGate' => 'booking_show',
                        'editGate' => 'booking_edit',
                        'deleteGate' => 'booking_delete',
                        'crudRoutePart' => 'bookings',
                        'row' => $booking])}}
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
            @endif
        </table>
    </div>
</div>
<form action="{{ route("admin.bookings.index") }}" method="GET">
    {{-- @csrf --}}
    <input type="hidden" name="filter" value="1">
    <div class="modal fade" id="filterOptions" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Booking Date</label>
                                <input type="text" class="form-control" name="book_date" id="bookDate" value="{{ request()->get('book_date') }}" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="#clients">Client</label>
                                <select name="clients[]" id="clients" class="form-control select2" multiple>
                                    <option></option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" {{ !is_null(request()->get('clients')) ? (in_array($client->id ,request()->get('clients')) ? 'selected' : '') : '' }}>
                                            {{ $client->name() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Room Type</label>
                                <select id="roomType" name="room_type" id="" class="form-control select2">
                                    <option></option>
                                    @foreach ($room_types as $room_type)
                                        <option value="{{ $room_type->id }}" @if(request()->get('room_type') == $room_type->id) selected @endif>
                                            {{ $room_type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="rooms">Room</label>
                                <select class="form-control select2" name="room" id="rooms" style="width: 100%">
                                    <option></option>
                                    {{-- @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $id ? 'selected' : '' }}>{{ $room->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Booking Status</label>
                                {{ request()->get('') }}
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="pending" name="booking_status[]" value="pending" {{ !is_null(request()->get('booking_status')) ? (in_array('pending' ,request()->get('booking_status')) ? 'checked' : '') : '' }}>
                                    <label class="form-check-label" for="pending">Pending</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="confirmed" name="booking_status[]" value="confirmed" {{ !is_null(request()->get('booking_status')) ? (in_array('confirmed' ,request()->get('booking_status')) ? 'checked' : '') : '' }}>
                                    <label class="form-check-label" for="confirmed">Confirmed</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checked_in" name="booking_status[]" value="checked in" {{ !is_null(request()->get('booking_status')) ? (in_array('checked in' ,request()->get('booking_status')) ? 'checked' : '') : '' }}>
                                    <label class="form-check-label" for="checked_in">Checked in</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checked_out" name="booking_status[]" value="checked out" {{ !is_null(request()->get('booking_status')) ? (in_array('checked out' ,request()->get('booking_status')) ? 'checked' : '') : '' }}>
                                    <label class="form-check-label" for="checked_out">Checked out</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="canceled" name="booking_status[]" value="canceled" {{ !is_null(request()->get('booking_status')) ? (in_array('canceled' ,request()->get('booking_status')) ? 'checked' : '') : '' }}>
                                    <label class="form-check-label" for="canceled">Canceled</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Payment Status</label>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="unpaid" name="payment_status[]" value="unpaid" {{ !is_null(request()->get('payment_status')) ? (in_array('unpaid' ,request()->get('payment_status')) ? 'checked' : '') : '' }}>
                                    <label class="form-check-label" for="unpaid">Unpaid</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="partial" name="payment_status[]" value="partial" {{ !is_null(request()->get('payment_status')) ? (in_array('partial' ,request()->get('payment_status')) ? 'checked' : '') : '' }}>
                                    <label class="form-check-label" for="partial">Partial</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="paid" name="payment_status[]" value="paid" {{ !is_null(request()->get('payment_status')) ? (in_array('paid' ,request()->get('payment_status')) ? 'checked' : '') : '' }}>
                                    <label class="form-check-label" for="paid">Paid</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if(request()->get('filter') == 1)
                    <a class="btn btn-primary" href="{{ route('admin.bookings.index') }}">Reset Filter</a>
                    @endif
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('scripts')
{{-- @parent --}}
<script src="{{ asset('website/plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('website/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>
    $(function(){
        /* $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); */
        if($('#roomType').val() != ''){
            filterRoom()
        }
        function filterRoom(){
            var base_url = '{{ URL::to('') }}';
            var id = $('#roomType').val();
            $.ajax({
                type:'GET',
                url: base_url+'/filter_room_by_type',
                data: {
                    room_type: id,
                    selected_room: {{ is_null(request()->get('room')) ? "null" : request()->get('room') }},
                },
                success:function(data){
                    $('#rooms').html(data.room_options);
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
        }
        $('#roomType').on('change', function(){
            filterRoom()
        });

        $('#bookDate').daterangepicker({
            // timePicker: true,
            // endDate: moment().startOf('hour').add(32, 'hour'),
            @if(!is_null(request()->get('book_date')))
            startDate: '{{ explode(' - ',request()->get('book_date'))[0] }}',
            endDate: '{{ explode(' - ',request()->get('book_date'))[1] }}',
            @endif
            autoUpdateInput: false,
            locale: {
                format: 'Y/M/DD',
                cancelLabel: 'Clear'
            },
        });

        $("#bookDate").on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('Y/M/DD') + ' - ' + picker.endDate.format('Y/M/DD'));
        });

        $("#bookDate").on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('booking_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.bookings.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                    return entry.id
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}')
                    return
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                    headers: {'x-csrf-token': _token},
                    method: 'POST',
                    url: config.url,
                    data: { ids: ids, _method: 'DELETE' }})
                    .done(function () { location.reload() })
                }
            }
        }
        dtButtons.push(deleteButton)
        @endcan

        @if(!request()->get('filter') == 1)
        let dtOverrideGlobals = {
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            ajax: "{{ route('admin.bookings.index') }}",
            columns: [
                { data: 'placeholder', name: 'placeholder' },
                { data: 'id', name: 'id' },
                { data: 'booking_status', name: 'booking_status' },
                { data: 'payment_status', name: 'payment_status' },
                { data: 'client_name', name: 'client.clientname'},
                { data: 'room_name', name: 'room.name' },
                { data: 'amount_paid' },
                { data: 'balance' },
                { data: 'amount' },
                { data: 'booking_date_from', name: 'booking_date_from' },
                { data: 'booking_date_to', name: 'booking_date_to' },
                { data: 'actions', name: '{{ trans('global.actions') }}' }
            ],
            order: [[ 1, 'desc' ]],
            pageLength: 100,
        };
        @elseif(request()->get('filter') == 1)
        let dtOverrideGlobals = {
            buttons: dtButtons
        };
        @endif
        $('.datatable-Booking').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
    });

</script>
@endsection