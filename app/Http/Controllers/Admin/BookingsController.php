<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeclineBooking;

class BookingsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $bookings = Booking::with(['room', 'client'=>function($q){
                $q->select([
                    'id',
                    DB::raw("CONCAT(first_name,' ',last_name) AS clientname")
                ]);
            }])
            ->get(); // used get() to query the concat columns
            // ->select(sprintf('%s.*', (new Booking)->table));
            $table = Datatables::of($bookings);


            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'booking_show';
                $editGate      = 'booking_edit';
                $deleteGate    = 'booking_delete';
                $crudRoutePart = 'bookings';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->addColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->addColumn('booking_status', function ($row) {
                return $row->getBookingStatus() ? $row->getBookingStatus() : "";
            });

            $table->addColumn('payment_status', function ($row) {
                return $row->getPaymentStatus() ? $row->getPaymentStatus() : "";
            });

            $table->addColumn('booking_date_from', function ($row) {
                return $row->booking_date_from ? date('Y-m-d', strtotime($row->booking_date_from)) : "";
            });

            $table->addColumn('booking_date_to', function ($row) {
                return $row->booking_date_to ? date('Y-m-d', strtotime($row->booking_date_to)) : "";
            });

            $table->addColumn('client_name', function ($row) {
                return $row->client ? $row->client->clientname : '';
            });

            $table->addColumn('room_name', function ($row) {
                return $row->room ? $row->room->name : '';
            });

            $table->addColumn('amount_paid', function ($row) {
                return $row->payments->sum('amount');
            });

            $table->addColumn('balance', function ($row) {
                return ($row->amount - $row->payments->sum('amount'));
            });

            $table->addColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'booking_status', 'payment_status', 'balance', 'amount_paid']);

            return $table->make(true);
        }
        $clients = User::join('role_user', 'users.id', '=', 'role_user.user_id')
                        ->select('*')
                        ->where('role_id', 3)->get();
        $data = [
            'room_types' => RoomType::get(),
            'clients' => $clients
        ];

        if($request->get('filter') == 1){
            $bookings = Booking::select('*');

            if(!is_null($request->get('clients'))){
                $bookings->wherein('user_id', $request->get('clients'));
            }

            if(!is_null($request->get('book_date'))){
                $book_date = explode(' - ',$request->get('book_date'));
                $book_from = date('Y-m-d', strtotime($book_date[0]));
                $book_to = date('Y-m-d', strtotime($book_date[1]));
                $bookings->where('booking_date_to', '<=', $book_to)->where(function($query){
                    $book_date = explode(' - ', request()->get('book_date'));
                    $book_from = date('Y-m-d', strtotime($book_date[0]));
                    $query->where('booking_date_from', '>=', $book_from);
                });
            }

            if(!is_null($request->get('room_type'))){
                $rooms = Room::where('room_type_id', $request->get('room_type'))->get('id');
                $bookings->wherein('room_id', $rooms);
            }

            if(!is_null($request->get('room'))){
                $bookings->where('room_id', $request->get('room'));
            }

            if(!is_null($request->get('booking_status'))){
                $bookings->wherein('booking_status', $request->get('booking_status'));
            }

            if(!is_null($request->get('payment_status'))){
                $bookings->wherein('payment_status', $request->get('payment_status'));
            }

            $data = [
                'bookings' => $bookings->orderBy('created_at', 'DESC')->get(),
                'room_types' => RoomType::get(),
                'clients' => $clients
            ];
        }
        return view('admin.bookings.index', $data);
    }

    public function create()
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $rooms = Room::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $clients = User::join('role_user', 'users.id', '=', 'role_user.user_id')
                        ->select('*')
                        ->where('role_id', 3)->get();
        $data = [
            'rooms' => Room::get(),  
            'room_types' => RoomType::get(),  
            'clients' => $clients,
        ];

        return view('admin.bookings.create', $data);
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'client' => 'required',
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

        if($amount == 0) {
            $amount = $room->amount;
        }

        $booking = Booking::create([
            'payment_status' => 'unpaid', 
            'booking_status' => 'pending',
            'room_id' => $request->get('room'),
            'user_id' => $request->get('client'),
            'amount' => $amount,
            'booking_date_from' => $book_date[0],
            'booking_date_to' => $book_date[1],
        ]);
        
        return redirect()->route('admin.bookings.index');
        /* // $booking = Booking::create($request->all());
        $room = Room::find($request->get('room_id'));
        $booking = Booking::create([
            'room_id' => $request->get('room_id'),
            'status' => 1,
            'user_id' => is_null($request->get('user_id')) ? Auth::user()->id : $request->get('user_id'),
            'amount' => $request->get('amount'),
            'payment_status' => 0,
            'booking_date' => $request->get('booking_date'),
            'amount' => $room->amount
        ]);

        return redirect()->route('admin.bookings.index'); */
    }

    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clients = User::join('role_user', 'users.id', '=', 'role_user.user_id')
                        ->select('*')
                        ->where('role_id', 3)->get();
        $data = [
            'rooms' => Room::get(),  
            'room_types' => RoomType::get(),  
            'clients' => $clients,
            'booking' => $booking,
        ];

        return view('admin.bookings.edit', $data);
    }

    public function update(Request $request, Booking $booking)
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'client' => 'required',
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
            'room_id' => $request->get('room'),
            'user_id' => $request->get('client'),
            'amount' => $amount,
            'booking_date_from' => $book_date[0],
            'booking_date_to' => $book_date[1],
        ]);
        
        return redirect()->route('admin.bookings.index');
    }

    public function show(Booking $booking)
    {
        abort_if(Gate::denies('booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->load('room', 'payments');

        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        abort_if(Gate::denies('booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->delete();

        return back();
    }

    public function massDestroy(MassDestroyBookingRequest $request)
    {
        Booking::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function confirm(Booking $booking)
    {
        $booking->update([
            'booking_status' => 'confirmed'
        ]);

        return redirect()->route('admin.bookings.show', $booking->id);
    }

    public function checkIn(Booking $booking)
    {
        $booking->update([
            'booking_status' => 'checked in'
        ]);

        return redirect()->route('admin.bookings.show', $booking->id);
    }

    public function checkOut(Booking $booking)
    {
        $booking->update([
            'booking_status' => 'checked out'
        ]);

        return redirect()->route('admin.bookings.show', $booking->id);
    }

    public function cancel(Booking $booking)
    {
        $booking->update([
            'booking_status' => 'canceled'
        ]);

        return redirect()->route('admin.bookings.show', $booking->id);
    }

    public function decline(Request $request, Booking $booking)
    {
        $booking->update([
            'booking_status' => 'declined',
            'decline_reason' => $request->decline_reason
        ]);
        Mail::to($booking->client->email)->send(new DeclineBooking($booking));

        return redirect()->route('admin.bookings.show', $booking->id);
    }

    public function printReport(Request $request)
    {
        $bookings = Booking::select('*');

        if(!is_null($request->get('clients'))){
            $bookings->wherein('user_id', $request->get('clients'));
        }

        if(!is_null($request->get('book_date'))){
            $book_date = explode(' - ',$request->get('book_date'));
            $book_from = date('Y-m-d', strtotime($book_date[0]));
            $book_to = date('Y-m-d', strtotime($book_date[1]));
            $bookings->where('booking_date_to', '<=', $book_to)->where(function($query){
                $book_date = explode(' - ', request()->get('book_date'));
                $book_from = date('Y-m-d', strtotime($book_date[0]));
                $query->where('booking_date_from', '>=', $book_from);
            });
        }

        if(!is_null($request->get('room_type'))){
            $rooms = Room::where('room_type_id', $request->get('room_type'))->get('id');
            $bookings->wherein('room_id', $rooms);
        }

        if(!is_null($request->get('room'))){
            $bookings->where('room_id', $request->get('room'));
        }

        if(!is_null($request->get('booking_status'))){
            $bookings->wherein('booking_status', $request->get('booking_status'));
        }

        if(!is_null($request->get('payment_status'))){
            $bookings->wherein('payment_status', $request->get('payment_status'));
        }

        $data = [
            'bookings' => $bookings->orderBy('created_at', 'DESC')->get(),
            'book_date' => $request->get('book_date'),
            'clients' => $request->get('clients'),
            'room_type' => $request->get('room_type'),
            'room' => $request->get('room'),
            'booking_status' => $request->get('booking_status'),
            'payment_status' => $request->get('payment_status'),
        ];

        return view('admin.bookings.report', $data);
    }
    
}
