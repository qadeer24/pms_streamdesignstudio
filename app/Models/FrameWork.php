<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrameWork extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];
}
