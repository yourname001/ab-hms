<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'bookings' => Booking::where('user_id', Auth::user()->id)->get()
            // 'bookings' => Booking::get()
        ];

        return view('website.bookings.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()){
            $date_from = request()->get('book_date');
            $data = [
                'rooms' => Room::get(),
                'room_types' => RoomType::get(),
                'date_from' => date('Y/m/d', strtotime($date_from)).' '.date('h:i A'),
                'date_to' => date('Y/m/d', strtotime("+1 day", strtotime($date_from))).' '.date('h:i A'),
            ];
            return response()->json([
                'modal_content' => view('website.bookings.create', $data)->render(),
                'date_from' => $date_from.' '.date('h:i A')
			]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_date' => 'required',
            'room_type' => 'required',
            'room' => 'required'
        ]);

        $room = Room::find($request->get('room'));
        $amount = $room->amount;

        $book_date = explode(' - ',$request->get('book_date'));
        $book_from = Carbon::parse($book_date[0]);
        $book_to = Carbon::parse($book_date[1]);

        $date_from = Carbon::createFromDate($book_from);
        // $days = $date_from->diffForHumans($book_to);
        $days = $date_from->diffInDays($book_to);
        /* $minutes = $date_from->diffInMinutes($book_to);

        // hours exceed
        $exceeding_hours = (($minutes/60) - ($days * 24));
        // minutues exceed
        $exceeding_minutes = (($minutes/60) - $exceeding_hours);

        $duration = $days . "Days " . $exceeding_hours . "Hours " . $exceeding_minutes . "Minutes";

        echo "Date: " . $request->get('book_date'). "<br>";
        echo "From: " . $book_from. "<br>";
        echo "To: " . $book_to. "<br>";
        echo "Duration: " . $duration. "<br>";
        // Compute Amount
        if($exceeding_hours > 0 || $exceeding_minutes > 0) {

        }else{
            $amount = $amount * $days;
        } */
        // echo "Amount: " . ($room->amount * $days);

        $amount = $amount * $days;

        $booking = Booking::create([
            'payment_status' => 'unpaid',
            'booking_status' => 'pending',
            'room_id' => $request->get('room'),
            'user_id' => Auth::user()->id,
            'amount' => $amount,
            'booking_date_from' => $book_date[0],
            'booking_date_to' => $book_date[1],
        ]);
        
        return back();
        // Mail::to(Auth::user())->send(new Booking($booking));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        if(request()->ajax()){
            $data = [
                'booking_show' => $booking
            ];
            return response()->json([
                'modal_content' => view('website.bookings.show', $data)->render()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }

    public function bookingExpired(Booking $booking)
    {
        $booking->update([
            'booking_status' => 'expired'
        ]);
    }

    public function cancelBooking(Booking $booking)
    {
        $booking->update([
            'booking_status' => 'canceled'
        ]);
    }

}
