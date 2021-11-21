<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <h1>Booking</h1>
    <p>You booked a room in Qatara Family Resort. Please pay the required reservation fee and wait for the confirmation of your booking.</p>
    <label>Details:</label>
    <ul style="list-style-type: none">
        <li>
            <b>Date: </b>
            {{ date("F d, Y", strtotime($booking->booking_date_from)) }}
            -
            {{ date("F d, Y", strtotime($booking->booking_date_to)) }}
        </li>
        <li>
            <b>Room: </b>
            {{ $booking->room->name }}
        </li>
        <li>
            <b>Amount: </b>
            ₱{{ number_format($booking->amount, 2) }}
        </li>
        <li>
            <b>Required Reservation Fee (30% of total amount):</b>
            ₱ {{ number_format(($booking->amount * 0.3), 2) }}
        </li>
    </ul>
    <p>Thank you for choosing <a href="{{ config('app.url') }}">Qatara Family Resort</a></p>
</body>
</html>