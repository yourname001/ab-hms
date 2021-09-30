<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <h1>Booking</h1>
    <p>You booked a room in Qatara Family Resort.</p>
    <label>Details:</label>
    <ul style="list-style-type: none">
        <li>
            <label>Date: </label>
            {{ date("f d, Y h:i A", strtotime($booking->boooking_date_from)) }}
            -
            {{ date("f d, Y h:i A", strtotime($booking->boooking_date_to)) }}
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