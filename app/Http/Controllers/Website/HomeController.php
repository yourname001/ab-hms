<?php

namespace App\Http\Controllers\Website;

use App\Models\Room;
use App\Models\RoomType;
use Carbon\CarbonPeriod;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ([
            'featuredRooms' => Room::where('featured', '1')->whereNotNull('image')->get(),
            'roomTypes' => RoomType::pluck('name', 'id')
        ]);
        return view('website.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function login()
    {
        if(request()->ajax()) {
            return response()->json([
                'modal_content' => view('website.account.login')->render()
            ]);
        }
    }

    public function register()
    {
        if(request()->ajax()) {
            return response()->json([
                'modal_content' => view('website.account.register')->render()
            ]);
        }
    }

    public function clientRegister(Request $request)
    {
        $request->validate([
            // 'name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:255', 'unique:users'],
            'address' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return reponse()->json([
                'success' => false,
                'asd' => $validator->getMessageBag()->toArray()

            ], 400); // 400 being the HTTP code for an invalid request.
        }

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'contact_number' => $data['contact_number'],
            'address' => $data['address'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        RoleUser::create([
            'user_id' => $user->id,
            'role_id' => 3
        ]);

        // $this->guard()->login($user);

        return reponse()->json(['success' => true], 200);

        /* return response()->json([
            'error'
        ]); */
    }
}
