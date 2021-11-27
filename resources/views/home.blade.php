@extends('layouts.admin')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $pending_bookings ?? '0' }}</h3>
                                    <p>Pending Bookings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-calendar-minus"></i>
                                </div>
                                <a href="{{ route('admin.bookings.index', ['filter' => '1', 'booking_status'=>['pending']]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>{{ $confirmed_bookings ?? '0' }}</h3>
                                    <p>Confirmed Bookings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-calendar-check"></i>
                                </div>
                                <a href="{{ route('admin.bookings.index', ['filter' => '1', 'booking_status'=>['confirmed']]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $checked_in_bookings ?? '0' }}</h3>
                                    <p>Checked In Bookings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bed"></i>
                                </div>
                                <a href="{{ route('admin.bookings.index', ['filter' => '1', 'booking_status'=>['checked in']]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $unpaid_bookings ?? '0' }}</h3>
                                    <p>Unpaid Bookings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-ban"></i>
                                </div>
                                <a href="{{ route('admin.bookings.index', ['filter' => '1', 'payment_status'=>['unpaid']]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
