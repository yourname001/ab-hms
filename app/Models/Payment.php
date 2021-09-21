<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'booking_id',
        'amount'
    ];

    public function booking() {
        return $this->belongsTo('App\Models\Booking', 'booking_id');
    }
}
