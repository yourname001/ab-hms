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
use Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(isset(Auth::user()->id)){
            if(Auth::user()->getIsAdminAttribute()){
                return redirect()->route('admin.home');
            }else{
                $data = ([
                    'featuredRooms' => Room::where('featured', '1')->whereNotNull('image')->get(),
                    'roomTypes' => RoomType::pluck('name', 'id')
                ]);
                return view('website.index', $data);
            }
        }else{
            $data = ([
                'featuredRooms' => Room::where('featured', '1')->whereNotNull('image')->get(),
                'roomTypes' => RoomType::pluck('name', 'id')
            ]);
            return view('website.index', $data);
        }
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

}
