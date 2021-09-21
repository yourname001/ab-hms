<?php

// Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
    // return redirect()->route('/');
});

Route::get('/resort', function () {
    return redirect()->route('resort.index');
    // return redirect()->route('/');
});

// Auth::routes(['register' => false]);
Auth::routes();
// Admin

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Hotels
    Route::delete('hotels/destroy', 'HotelsController@massDestroy')->name('hotels.massDestroy');
    Route::resource('hotels', 'HotelsController');

    // Room Types
    Route::delete('room-types/destroy', 'RoomTypesController@massDestroy')->name('room-types.massDestroy');
    Route::resource('room-types', 'RoomTypesController');

    // Rooms
    Route::delete('rooms/destroy', 'RoomsController@massDestroy')->name('rooms.massDestroy');
    Route::resource('rooms', 'RoomsController');

    // Bookings
    Route::delete('bookings/destroy', 'BookingsController@massDestroy')->name('bookings.massDestroy');
    Route::resource('bookings', 'BookingsController');
});

// Client
Route::get('/', function () {
    return redirect()->route('resort.index');
})->name('homepage');

Route::resource('resort', 'Website\HomeController')->parameters([
    'resort' => 'homes'
]);
