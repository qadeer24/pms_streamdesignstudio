<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'role',
        'email',
        'member_img',
        'joined_at',
        'contact_no',
        'description',
        'responsibility_level',
        'position',
        'salary'
    ];
}