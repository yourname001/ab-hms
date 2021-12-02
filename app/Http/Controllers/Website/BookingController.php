<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Auth;
use App\Mail\SendBookingConfirmationMail;

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
            'room' => 'required',
            'proof_of_identity' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $room = Room::find($request->get('room'));
        $amount = $room->amount;

        $book_date = explode(' - ',$request->get('book_date'));
        $book_from = Carbon::parse($book_date[0]);
        $book_to = Carbon::parse($book_date[1]);

        $date_from = Carbon::createFromDate($book_from);

        $days = $date_from->diffInDays($book_to);
        $amount = $amount * $days;

        $booking = Booking::create([
            'payment_status' => 'unpaid',
            'booking_status' => 'pending',
            'room_id' => $request->get('room'),
            'user_id' => Auth::user()->id,
            'amount' => $amount,
            'booking_date_from' => $book_from,
            'booking_date_to' => $book_to,
        ]);

        Mail::to($booking->client->email)->send(new SendBookingConfirmationMail($booking));

        if($request->file('proof_of_identity')){
            $image = $request->file('proof_of_identity');
            $storagePath = 'images/user';
            $fileName = $booking->id . '_' . date('m-d-Y H.i.s') . '.' . $image->getClientOriginalExtension();
            Storage::disk('upload')->putFileAs('images/proof-of-identity/', $image, $fileName);
            $booking->update([
                'type_of_identification' => $request->get('type_of_identification'),
                'proof_of_identity' => $fileName
            ]);
        }
        
        return redirect()->route('client_bookings.index')->with('alert-success', 'Booking Success');

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
        if(request()->ajax()) {
            $data = [
                'booking' => $booking,
                'room_types' => RoomType::get(),
            ];
            return response()->json([
                'modal_content' => view('website.bookings.edit', $data)->render()
            ]);
        }
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

        $days = $date_from->diffInDays($book_to);

        $amount = $amount * $days;

        $booking->update([
            // 'payment_status' => 'unpaid',
            // 'booking_status' => 'pending',
            'room_id' => $request->get('room'),
            'user_id' => Auth::user()->id,
            'amount' => $amount,
            'booking_date_from' => $book_date[0],
            'booking_date_to' => $book_date[1],
        ]);
        
        return redirect()->route('client_bookings.index');
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
        return redirect()->route('client_bookings.index');
    }

    public function cancelBooking(Request $request, Booking $booking)
    {
        $request->validate([
            'reason_of_cancellation' => 'required'
        ]);
        $booking->update([
            'reason_of_cancellation' => $request->get('reason_of_cancellation'),
            'other_reasons' => $request->get('other_reasons'),
            'booking_status' => 'canceled'
        ]);
        return redirect()->route('client_bookings.index');
    }
}
