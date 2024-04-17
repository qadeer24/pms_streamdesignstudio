<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;
    protected $dates    = ['deleted_at'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'contact_no',
        'description',
        'invited_by',
        'profile_pic',
        'pin_code',
        'active',
        'session_status',
        'created_by',
        'updated_by'
    ];

   
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getActiveAttribute($value)
    {
        return ($value == 1) ? "Active" : "Inactive";
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('M d, Y');
    }

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'comment_by');
    }
}
