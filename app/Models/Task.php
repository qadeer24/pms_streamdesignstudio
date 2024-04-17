<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'task_img',
        'project_id',
        'assigned_to',
        'deadline',
        'task_status',
        'created_by',
    ];
}
