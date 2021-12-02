<?php
use Illuminate\Http\Request;

// Route::redirect('/', '/login');
Route::get('/home', function () {
    /* if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home'); */
    return redirect()->route('resort.index');
});


/* Resend Verification Email */


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/resort', function () {
    return redirect()->route('resort.index');
    // return redirect()->route('/');
})->middleware('verified');

// Auth::routes(['register' => false]);
Auth::routes(['verify' => true]);
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
    // Route::get('get_room_info/', 'Admin\RoomController@getRoomInfo')->name('rooms.get_room_info');
    

    // Bookings
    Route::delete('bookings/destroy', 'BookingsController@massDestroy')->name('bookings.massDestroy');
    Route::resource('bookings', 'BookingsController');
    Route::get('print-booking-report', 'BookingsController@printReport')->name('bookings.print_report');
    Route::get('bookings/confirm/{booking}', 'BookingsController@confirm')->name('bookings.confirm');
    Route::get('bookings/check-in/{booking}', 'BookingsController@checkIn')->name('bookings.check_in');
    Route::get('bookings/check-out/{booking}', 'BookingsController@checkOut')->name('bookings.checkout');
    Route::get('bookings/cancel/{booking}', 'BookingsController@cancel')->name('bookings.cancel');
    Route::post('bookings/decline/{booking}', 'BookingsController@decline')->name('bookings.decline');

    // payments
    Route::resource('payments', 'PaymentsController');
    Route::delete('payments/destroy', 'PaymentsController@massDestroy')->name('payments.massDestroy');

    // payments
    // Route::get('admin/payments/create', 'Admin\BookingsController@createPayment')->name('admin.payments.create');
});

// Client
Route::get('/', function () {
    return redirect()->route('resort.index');
})->name('homepage');

Route::resource('resort', 'Website\HomeController')->parameters([
    'resort' => 'homes'
]);
Route::get('resort_login', 'Website\HomeController@login')->name('client.login');
Route::get('resort_register', 'Website\HomeController@register')->name('client.register');
// Route::post('client_register', 'Website\HomeController@clientRegister')->name('client.client_register');

Route::group(array('middleware'=>['auth']), function() {
    Route::resource('client_bookings', 'Website\BookingController')->parameters([
		'client_bookings' => 'booking'
    ]);

    Route::put('client_booking/cancel/{booking}', 'Website\BookingController@cancelBooking')->name('client_bookings.cancel');

    Route::get('get_room_info/{room}', 'Admin\RoomsController@get_room_info');

    Route::get('client_cooking/payments/{booking}', 'Website\BookingController@payments')->name('client_bookings.payments');

    Route::post('filter_rooms', 'Admin\RoomsController@filter_rooms');
    Route::get('filter_room_by_type', 'Admin\RoomsController@filterRoomByType');
    Route::resource('payments', 'Website\PaymentController');

    // Client
    Route::get('client/account/{user}', 'Website\ClientController@account')->name('client.account');
    Route::put('client/account/update/{user}', 'Website\ClientController@updateAccount')->name('client.update');
});
