<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Room;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class BookingsController extends Controller
{
    public function index(Request $request)
    {
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

            $table->rawColumns(['actions', 'placeholder', 'booking_status']);

            return $table->make(true);
        }

        return view('admin.bookings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rooms = Room::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.bookings.create', compact('rooms'));
    }

    public function store(StoreBookingRequest $request)
    {
        // $booking = Booking::create($request->all());
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

        return redirect()->route('admin.bookings.index');
    }

    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rooms = Room::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $booking->load('room');

        return view('admin.bookings.edit', compact('rooms', 'booking'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->all());

        return redirect()->route('admin.bookings.index');
    }

    public function show(Booking $booking)
    {
        abort_if(Gate::denies('booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->load('room');

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

    public function cancel(Booking $booking)
    {
        $booking->update([
            'booking_status' => 'canceled'
        ]);

        return redirect()->route('admin.bookings.show', $booking->id);
    }
    
}
