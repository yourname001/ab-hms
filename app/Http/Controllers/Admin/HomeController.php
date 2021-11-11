<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Booking;
use Carbon\CarbonPeriod;

class HomeController
{
    public function index()
    {
        $data = [
            'pending_bookings' => Booking::where('booking_status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('booking_status', 'confirmed')->count(),
            'checked_in_bookings' => Booking::where('booking_status', 'checked in')->count(),
            'unpaid_bookings' => Booking::where('payment_status', 'unpaid')->count(),
        ];
        return view('home', $data);
    }
}
