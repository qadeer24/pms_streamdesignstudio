<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'project_img',
        'created_by',
        'assigned_to',
        'tech_stack',
        'project_category',
        'db_name',
        'deadline',
        'project_progress',
        'project_price',
        'project_status'
    ];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('M d, Y');
    }

    public function getProjectStatusAttribute($value)
    {
        switch ($value) {
            case '1':
                return "In progress - Active";
            break;

            case '0':
                return "Completed - Inactive";
            break;
            
            default:
                return "In Progress - Active";
            break;
        }
    }
    public function getDeadlineAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('M d, Y');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
