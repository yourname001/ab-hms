<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRoomRequest;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Booking;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class RoomsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Room::with(['room_type'])->select(sprintf('%s.*', (new Room)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'room_show';
                $editGate      = 'room_edit';
                $deleteGate    = 'room_delete';
                $crudRoutePart = 'rooms';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('image', function ($row) {
                return $row->image ? '<img src="'.asset('images/rooms/'.$row->image).'" width="100px">' : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->addColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->addColumn('capacity', function ($row) {
                return $row->capacity ? $row->capacity : '';
            });

            $table->addColumn('room_type_name', function ($row) {
                return $row->room_type ? $row->room_type->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'room_type', 'image']);

            return $table->make(true);
        }

        return view('admin.rooms.index');
    }

    public function create()
    {
        abort_if(Gate::denies('room_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $room_types = RoomType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.rooms.create', compact('room_types'));
    }

    public function store(StoreRoomRequest $request)
    {
        // $room = Room::create($request->all());

        $request->validate([
			'room_type_id' => 'required',
			'name' => 'required',
			'capacity' => 'required',
			'amount' => 'required'
        ]);
        
        if($request->file('image')){
            

            $file = $request->file('image');
            $fileName = $request->get('name') . '_' . date('m-d-Y H.i.s') . '.' . $file->getClientOriginalExtension();
            Storage::disk('upload')->putFileAs('images/rooms', $request->file('image'), $fileName);
            $room = Room::create([
                'featured' => is_null($request->get('featured')) ? 0 : 1,
                'amount' => is_null($request->get('amount')) ? 0 : $request->get('amount'),
                'room_type_id' => $request->get('room_type_id'),
                'name' => $request->get('name'),
                'capacity' => $request->get('capacity'),
                'description' => $request->get('description'),
            ]);
            $room->update([
                'image' => $fileName
            ]);
        }
        
        return redirect()->route('admin.rooms.index');
    }

    public function edit(Room $room)
    {
        abort_if(Gate::denies('room_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hotels = Hotel::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $room_types = RoomType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $room->load('hotel', 'room_type');

        return view('admin.rooms.edit', compact('room_types', 'room'));
    }

    public function update(UpdateRoomRequest $request, Room $room)
    {
        $room->update($request->all());

        return redirect()->route('admin.rooms.index');
    }

    public function show(Room $room)
    {
        abort_if(Gate::denies('room_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $room->load('hotel', 'room_type', 'roomBookings');

        return view('admin.rooms.show', compact('room'));
    }

    public function destroy(Room $room)
    {
        abort_if(Gate::denies('room_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $room->delete();

        return back();
    }

    public function massDestroy(MassDestroyRoomRequest $request)
    {
        Room::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function filter_rooms(Request $request)
    {
        $book_date = $request->get('book_date');
        $book_from = explode(' - ', $book_date)[0];
        $book_to = explode(' - ', $book_date)[1];
        // $bookings = Booking::whereBetween('booking_date_from', [$book_from, $book_to])->get('room_id');
        $bookings = Booking::where('booking_status', '>', 0)
                            ->get('room_id');
        // $rooms = Room::where('room_type_id', $request->get('room_type'))->whereNotIn('id', $bookings)->get();
        $rooms = Room::where('room_type_id', $request->get('room_type'))->whereNotIn('id', $bookings)->get();
		$options = '<option></option>';
		foreach ($rooms as $room) {
			$options .= '<option value="'.$room->id.'">';
			$options .= $room->name;
			$options .= ' (Max Person: '.$room->capacity.')';
			$options .= ' [Amount/Day: ₱'.number_format($room->amount,2).']';
			$options .= '</option>';
		}
		return response()->json([
            'room_options' => $options,
            'book_from' => $book_from,
            'book_to' => $book_to,
            'bookings' => $bookings,
        ]);
    }
}
