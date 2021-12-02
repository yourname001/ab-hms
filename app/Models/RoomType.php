<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class RoomType extends Model
{
    

    public $table = 'room_types';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function roomTypeRooms()
    {
        return $this->hasMany('App\Models\Room', 'room_type_id', 'id');
    }
}
