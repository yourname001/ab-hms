<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $user = User::create([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'contact_number' => $request->get('contact_number'),
            'address' => $request->get('address'),
            'email' => $request->get('email'),
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make($request->get('password')),
        ]);
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $user->load('roles');

        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(Request $request, User $user)
    {
        $user->update([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'contact_number' => $request->get('contact_number'),
            'address' => $request->get('address'),
            'email' => $request->get('email'),
            'email_verified_at' => Carbon::now(),
            'password' => $request->get('password'),
        ]);
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');

        // return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
