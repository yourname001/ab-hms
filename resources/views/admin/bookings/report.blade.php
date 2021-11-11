<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Qatara Family Resort | Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        .filter-data .form-group {
            margin-bottom: 0px
        }
        .filter-data label {
            font-weight: bold
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h4>Booking Report</h4>
                <p>{{ date('F d, Y') }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 filter-data">
                <div class="form-group">
                    <label>Booking Date: </label>
                    {{ is_null($book_date) ? "*" : $book_date }}
                </div>
                <div class="form-group">
                    <label>Clients: </label>
                    @if(!is_null($clients))
                        @forelse ($clients as $client)
                            {{ App\Models\User::find($client)->name() }}@if(!$loop->last), @endif
                        @empty
                        @endforelse
                    @else
                    *
                    @endif
                </div>
                <div class="form-group">
                    <label>Room Type:</label>
                    {{ App\Models\RoomType::find($room_type)->name ?? "*" }}
                </div>
                <div class="form-group">
                    <label>Room:</label>
                    {{ App\Models\Room::find($room)->name ?? "*" }}
                </div>
                <div class="form-group">
                    <label>Booking Status: </label>
                    @if(!is_null($booking_status))
                        @forelse ($booking_status as $booking_status)
                            {{ $booking_status }}@if(!$loop->last), @endif
                        @empty
                        *
                        @endforelse
                    @else
                    *
                    @endif
                </div>
                <div class="form-group">
                    <label>Payment Status: </label>
                    @if(!is_null($payment_status))
                        @forelse ($payment_status as $payment_status)
                            {{ $payment_status }}@if(!$loop->last), @endif
                        @empty
                        *
                        @endforelse
                    @else
                    *
                    @endif
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <td></td>
                            <th>Booking Status</th>
                            <th>Payment Status</th>
                            <th>Client Name</th>
                            <th>Room</th>
                            <th>Amount Paid</th>
                            <th>Balance</th>
                            <th>Amount</th>
                            <th>Booking Date From</th>
                            <th>Booking Date To</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $index => $booking)
                        <tr>
                            <td>
                                {{ $index+1 }}
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
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</body>
</html>