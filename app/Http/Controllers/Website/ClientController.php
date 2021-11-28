<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Image;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function account(User $user)
    {
        $data = [
            'user' => $user
        ];
        return view('website.account.index', $data);
    }

    public function updateAccount(Request $request, User $user)
    {
        /* $user->update([
            'password' => Hash::make($request->get('password'))
        ]); */
        if(!is_null($request->get('old_password'))){
            if(Hash::check($request->get('old_password'), $user->password)){
                $request->validate([
                    'old_password' => 'required',
                    'new_password' => 'confirmed|min:8|different:old_password'
                ]);
                
                $user->update([
                    'password' => Hash::make($request->get('new_password'))
                ]);
            }
        }
        if($request->file('image')){
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg'
            ]);
            $avatar= $request->file('image');
            $thumbnailImage = Image::make($avatar);

            $storagePath = 'images/user';
            $fileName = $user->id . '_' . date('m-d-Y H.i.s') . '.' . $avatar->getClientOriginalExtension();
            $myimage = $thumbnailImage->fit(500);
            // Storage::disk('upload')->putFileAs('images/rooms', $request->file('image'), $fileName);
            $myimage->save($storagePath . '/' .$fileName);
            $user->update([
                'image' => $fileName
            ]);
            /* $file = $request->file('image');
            $fileName = $request->get('name') . '_' . date('m-d-Y H.i.s') . '.' . $file->getClientOriginalExtension();
            Storage::disk('upload')->putFileAs('images/rooms', $request->file('image'), $fileName);
            $user->update([
                'image' => $fileName
            ]); */
        }
        return redirect()->route('client.account', $user->id)->with('alert-success', 'Saved');
    }
    
}
