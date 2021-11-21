<div class="modal fade" id="showBooking" {{-- data-backdrop="static" --}} data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog {{-- modal-dialog-centered  --}}modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Booking</h5>
                <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Booking Status:</label>
                            {!! $booking_show->getBookingStatus() !!}
                            <br>
                            @if($booking_show->isCanceled())
                            <label>Reason of Cancellation:</label>
                            {{ $booking_show->reason_of_cancellation }}
                            <br>
                            <label>Other reasons:</label>
                            {{ $booking_show->other_reasons }}
                            <br>
                            @endif
                            <label>Book Date:</label>
                            {{ date('F d, Y h:i A', strtotime($booking_show->booking_date_from)) }}
                            -
                            {{ date('F d, Y h:i A', strtotime($booking_show->booking_date_to)) }}
                            <br>
                            <label>Room Type:</label>
                            {{ $booking_show->room->room_type->name }}
                            <br>
                            <label>Room:</label>
                            {{ $booking_show->room->name }}
                            <br>
                            <label>Amount:</label>
                            ₱ {{ number_format($booking_show->amount, 2) }}
                            <br>
                            <label>Amount Paid:</label>
                            ₱ {{ number_format($booking_show->payments->sum('amount'), 2) }}
                            <br>
                            <label>Balance:</label>
                            ₱ {{ number_format(($booking_show->amount - $booking_show->payments->sum('amount')), 2) }}
                            <br>
                            <label>Required Reservation Fee (30% of total amount):</label>
                            ₱ {{ number_format(($booking_show->amount * 0.3), 2) }}
                        </div>
                        <hr>
                        <div class="form-group">
                            @if(!$booking_show->isCanceled())
                                @if($booking_show->amount > $booking_show->payments->sum('amount'))
                                    <label>Pay with:</label>
                                    <a href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('payments.create', ['payment_method'=>'gcash', 'booking_id'=>$booking_show->id]) }}" data-target="#bookingPayment"><img src="{{ asset('images/gcash-logo.png') }}" alt="gcash" width="50px"></a>
                                    <br>
                                    <br>
                                @endif
                            @endif
                            <h5 class="text-center">Payments</h5>
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($booking_show->payments as $payment)
                                        <tr data-toggle="modal-ajax" data-target="#showPayment" data-href="{{ route('payments.show', $payment->id) }}">
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
            </div>
            <div class="modal-footer">
                @if($booking_show->booking_status == 'pending')
                    <a class="btn btn-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('client_bookings.edit', $booking_show->id) }}" data-target="#editBooking"><i class="fas fa-edit"></i> Edit</a>
                    <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#cancelBooking"><i class="fas fa-times"></i> Cancel Booking</button>
                @endif
            </div>
        </div>
    </div>
</div>
@if($booking_show->booking_status == 'pending')
<form action="{{ route('client_bookings.cancel', $booking_show->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal" id="cancelBooking" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cancel Booking</h5>
                </div>
                <div class="modal-body">
                    Are you sure do you want to cancel your booking?
                    <hr>
                    <div class="form-group">
                        <label>Reason:</label>
                        <select class='select2 form-control' name="reason_of_cancellation" required>
                            <option></option>
                            <option value="Payment issues">Payment issues</option>
                            <option value="Change of mind">Change of mind</option>
                            <option value="Change of business event/date">Change of business event/date</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Other Reason:</label>
                        <textarea class="form-control" name="other_reasons"  rows="3"></textarea>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Yes</button>
                    <button class="btn btn-default" type="button" data-target="cancelBooking" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endif