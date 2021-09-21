<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    public $table = 'role_user';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'role_id'
    ];
}
