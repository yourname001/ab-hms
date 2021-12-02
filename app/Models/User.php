<?php

namespace App\Models;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public $table = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'email_verified_at',
    ];

    protected $fillable = [
        'image',
        'first_name',
        'last_name',
        'contact_number',
        'address',
        'email',
        'password',
        'created_at',
        'updated_at',
        'remember_token',
        'email_verified_at',
    ];

    public function getFullName($type)
    {
        $full_name = "";
        switch ($type) {
            case 'fnf':
                $full_name = $this->first_name . " " . $this->last_name;
                break;
            case 'lnf':
                $full_name = $this->last_name . ", " . $this->first_name;
                break;
        }
        return $full_name;
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function name()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /* public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    } */

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
