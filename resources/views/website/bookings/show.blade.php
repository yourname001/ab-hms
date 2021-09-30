<div class="modal fade" id="showBooking" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <label>Book Date:</label>
                            {{ date('F d, Y', strtotime($booking_show->booking_date_from)) }}
                            -
                            {{ date('F d, Y', strtotime($booking_show->booking_date_to)) }}
                            <br>
                            <label>Amount:</label>
                            ₱ {{ number_format($booking_show->amount, 2) }}
                            <br>
                            <label>Amount Paid:</label>
                            ₱ {{ number_format($booking_show->payments->sum('amount'), 2) }}
                            <br>
                            <label>Balance:</label>
                            ₱ {{ number_format(($booking_show->amount-$booking_show->payments->sum('amount')), 2) }}
                        </div>
                        <hr>
                        <div class="form-group">
                            @if($booking_show->payments->sum('amount') < $booking_show->amount)
                            <label>Pay with:</label>
                            <a href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('payments.create', ['payment_method'=>'gcash', 'booking_id'=>$booking_show->id]) }}" data-target="#bookingPayment"><img src="{{ asset('images/gcash-logo.png') }}" alt="gcash" width="50px"></a>
                            <br>
                            <br>
                            @endif
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
                {{-- <a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('client_bookings.payments', ['booking_id'=>$booking_show->id]) }}"><i class="fas fa-money-bill-alt"></i> Payment</a> --}}
            </div>
        </div>
    </div>
</div>