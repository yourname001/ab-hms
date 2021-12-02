<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Booking extends Model
{
    

    public $table = 'bookings';

    /* protected $dates = [
        'updated_at',
        'created_at',
        'booking_date_from',
        'booking_date_to',
    ]; */

    protected $fillable = [
        'type_of_identification',
        'proof_of_identity',
        'room_id',
        'user_id',
        'booking_date_from',
        'booking_date_to',
        'amount',
        'payment_status',
        'booking_status',
        'reason_of_cancellation',
        'other_reasons',
        'decline_reason',
        'created_at',
        'updated_at',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function client() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payments() {
        return $this->hasMany('App\Models\Payment', 'booking_id');
    }

    /* public function getBookingDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setBookingDateAttribute($value)
    {
        $this->attributes['booking_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    } */

    public function getBookingStatus()
    {
        $status = "";
        switch($this->booking_status){
            case 'pending':
                $status = '<span class="badge badge-warning">Pending</span>';
                break;
            case 'confirmed':
                $status = '<span class="badge badge-primary">Confirmed</span>';
                break;
            case 'checked in':
                $status = '<span class="badge badge-success">Checked In</span>';
                break;
            case 'checked out':
                $status = '<span class="badge badge-secondary">Checked Out</span>';
                break;
            case 'canceled':
                $status = '<span class="badge badge-danger">Canceled</span>';
                break;
            case 'declined':
                $status = '<span class="badge badge-danger">Declined</span>';
                break;
            case 'expired':
                $status = '<span class="badge badge-danger">Expired</span>';
                break;
        }
        return $status;
    }

    public function getPaymentStatus()
    {
        $status = "";
        switch($this->payment_status){
            case 'unpaid':
                $status = '<span class="badge badge-warning">Unpaid</span>';
                break;
            case 'partial':
                $status = '<span class="badge badge-primary">Partial</span>';
                break;
            case 'paid':
                $status = '<span class="badge badge-success">Paid</span>';
                break;
        }
        return $status;
    }

    public function isPaid()
    {
        $confirmedPayment = $this->payments->where('payment_status', 'confirmed')->sum('amount');
        if($this->amount <= $confirmedPayment){
            return true;
        }
        return false;
    }

    public function isCanceled()
    {
        return self::where([
            ['id', $this->id],
            ['booking_status', 'canceled'],
        ])->exists();
    }

    public function proofOfIdentity()
    {
        $image = "";
        if(is_null($this->proof_of_identity)){
            $image = "images/image-icon.png"; 
        }else{
            $image = "images/proof-of-identity/".$this->proof_of_identity; 
        }
        return $image;
    }

}
