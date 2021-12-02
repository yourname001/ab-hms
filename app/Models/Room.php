<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Room extends Model
{
    

    public $table = 'rooms';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'room_type_id',
        'featured',
        'name',
        'capacity',
        'image',
        'description',
        'amount',
        'created_at',
        'updated_at',
    ];

    public function roomBookings()
    {
        return $this->hasMany(Booking::class, 'room_id', 'id');
    }

    public function room_type()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function scopeFilters($query)
    {
        return $query
            ->when(request()->input('room_type'), function ($query) {
                $query->where('room_type_id', request()->input('room_type'));
            })
            ->when(request()->input('room'), function ($query) {
                $query->where('name', 'LIKE', '%'.request()->input('room').'%');
            });
    }

    public function roomImage()
    {
        $image = "";
        if(is_null($this->image)){
            $image = "images/image-icon.png"; 
        }else{
            $image = "images/rooms/".$this->image; 
        }
        return $image;
    }
}
