@extends('layouts.admin')
@section('styles')
    <style>
        .form-group {
            margin-bottom: 0px
        }
    </style>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.booking.title') }}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <legend>Booking Info</legend>
                <div class="form-group">
                    <label>Booking Status:</label>
                    {!! $booking->getBookingStatus() !!}
                </div>
                <div class="form-group">
                    <label>Booking Date:</label>
                    {{ date('F d, Y', strtotime($booking->booking_date_from)) }}
                    -
                    {{ date('F d, Y', strtotime($booking->booking_date_to)) }}
                </div>
                <div class="form-group">
                    <label>Amount:</label>
                    ₱ {{ number_format($booking->amount, 2) }}
                </div>
                <div class="form-group">
                    <label>Room:</label>
                    {{ $booking->room->name }}
                </div>
                <div class="form-group">
                    <label>Name:</label>
                    {{ $booking->client->getFullName('fnf') ?? "" }}
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    {{ $booking->client->email }}
                </div>
                <div class="form-group">
                    <label>Contact #:</label>
                    {{ $booking->client->contact_number }}
                </div>
            </div>
            <div class="col-md-6">
                <legend>Payment Info</legend>
                <div class="form-group">
                    <label>Payment Status:</label>
                    {!! $booking->getPaymentStatus() !!}
                </div>
                <div class="form-group">
                    <label>Amount Paid:</label>
                    ₱ {{ number_format($booking->payments->sum('amount'), 2) }}
                </div>
                <div class="form-group">
                    <label>Balance:</label>
                    ₱ {{ number_format(($booking->amount-$booking->payments->sum('amount')), 2) }}
                </div>
                <table class="table table-sm table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($booking->payments as $payment)
                            <tr data-toggle="modal-ajax" data-target="#showPayment" @if($payment->payment_status == 'pending') data-href="{{ route('payments.edit', $payment->id) }}" @else data-href="{{ route('payments.show', $payment->id) }}" @endif>
                                <td>
                                    {!! $payment->getPaymentStatus() !!}
                                </td>
                                <td>{{ date('F d, Y h:i A', strtotime($payment->created_at)) }}</td>
                                <td>₱ {{ number_format($payment->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-danger text-center" colspan="3">*** EMPTY ***</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-body">
        <a class="btn btn-default" href="{{ route('admin.bookings.index') }}">
            {{ trans('global.back_to_list') }}
        </a>
        @if($booking->booking_status == 'pending')
        <a class="btn btn-success" href="{{ route('admin.bookings.confirm', $booking->id) }}">Confirm Booking</a>
        <a class="btn btn-danger" href="{{ route('admin.bookings.cancel', $booking->id) }}">Cancel Booking</a>
        @elseif($booking->booking_status == 'confirmed')
        <a class="btn btn-success" href="{{ route('admin.bookings.check_in', $booking->id) }}">Client Checked In</a>
        <a class="btn btn-danger" href="{{ route('admin.bookings.cancel', $booking->id) }}">Cancel Booking</a>
        @endif
    </div>
</div>
<div id="modalAjax"></div>
<div id="modalOpenData"></div>
@endsection
@section('scripts')
<script>
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Modal Ajax
        $(document).on('click', '[data-toggle="modal-ajax"]', function(){
            $('#loader').show();
            var href = $(this).data('href');
            var target = $(this).data('target');
            var data = {};
            if($(this).data('form') != null){
                var form = $(this).data('form').split(';');
                for (var i = 0; i < form.length; i++) {
                    var form_data = form[i].split(':');
                    for(var j = 1; j < form_data.length; j++){
                        data[form_data[j-1]] = form_data[j];
                    }
                }
            }
            $.ajax({
                type: 'GET',
                url: href,
                data: data,
                success: function(data){
                    $('.modal-backdrop').remove()
                    $('#modalAjax').html(data.modal_content)
                    $('.select2').select2({
                        theme: "bootstrap4",
                        placeholder: "Select",
                        allowClear: true
                    });
                    $('.datetimepicker').datetimepicker();
                    $('#oldInput').find('input').each(function(){
                        var name = $(this).attr('name').replace('old_', '');
                        if(name != '_token'){
                            var value = $(this).val();
                            $('#modalAjax [name="'+name+'"]').parent('.form-group').find('.invalid-feedback').html('<strong class="text-danger">'+$(this).data('error-message')+'</strong>')
                            $('#modalAjax').find('input[type="text"][name="'+name+'"]').val(value).addClass($(this).data('error'));
                            $('#modalAjax').find('input[type="checkbox"][name="'+name+'"][value="'+value+'"]').prop('checked', true);
                            $('#modalAjax').find('input[type="radio"][name="'+name+'"][value="'+value+'"]').prop('checked', true);
                            $('#modalAjax').find('select[name="'+name+'"]').val(value).trigger('change').addClass($(this).data('error'));
                        }
                    })
                    $(target).modal('show')
                    $('#loader').hide();
                },
                error: function(xhr, ajaxOptions, thrownError){
                    ajax_error(xhr, ajaxOptions, thrownError)
                    // removeLocationHash()
                    $('#loader').hide();
                }
            })
        })

        $(document).on('click', '[data-dismiss="modal-ajax"]', function() {
            // closeAllModals()
            $('.modal').modal('hide')
            $('.modal-backdrop').fadeOut(250, function() {
                $('.modal-backdrop').remove()
            })
            $('body').removeClass('modal-open').css('padding-right', '0px');
            $('#oldInput').html('');
            $('#modalAjax').html('')
            removeLocationHash()
        })

        function removeLocationHash(){
            var noHashURL = window.location.href.replace(/#.*$/, '');
            window.history.replaceState('', document.title, noHashURL)
        }
    })
</script>
@endsection