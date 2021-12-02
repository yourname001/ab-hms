<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Booking;
use Carbon\CarbonPeriod;
use Auth;

class HomeController
{
    public function index()
    {
        if(isset(Auth::user()->id)){
            if(Auth::user()->getIsAdminAttribute()){
                $data = [
                    'pending_bookings' => Booking::where('booking_status', 'pending')->count(),
                    'confirmed_bookings' => Booking::where('booking_status', 'confirmed')->count(),
                    'checked_in_bookings' => Booking::where('booking_status', 'checked in')->count(),
                    'unpaid_bookings' => Booking::where('payment_status', 'unpaid')->count(),
                ];
                return view('home', $data);
            }elseif(Auth::user()->roles()->where('id', 2)->exists()){
                $data = [
                    'pending_bookings' => Booking::where('booking_status', 'pending')->count(),
                    'confirmed_bookings' => Booking::where('booking_status', 'confirmed')->count(),
                    'checked_in_bookings' => Booking::where('booking_status', 'checked in')->count(),
                    'unpaid_bookings' => Booking::where('payment_status', 'unpaid')->count(),
                ];
                return view('home', $data);
            }else{
                return redirect()->route('resort.index');
            }
        }else{
            return redirect()->route('resort.index');
        }
        
    }
}
