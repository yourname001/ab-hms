<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <h1>Booking Declined</h1>
    <p>Your booking has been declined. If you've made a payment, please reply to this email for the refund process.</p>
    <label>Booking Details:</label>
    <ul style="list-style-type: none">
        <li>
            <label>Reason: </label>
            {{ $booking->decline_reason }}
        </li>
        <li>
            <label>Date: </label>
            {{ date("F d, Y", strtotime($booking->booking_date_from)) }}
            -
            {{ date("F d, Y", strtotime($booking->booking_date_to)) }}
        </li>
        <li>
            <label>Room: </label>
            {{ $booking->room->name }}
        </li>
        <li>
            <label>Amount: </label>
            {{ $booking->amount }}
        </li>
    </ul>
   
    <p>Thank you</p>
</body>
</html>