<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'comment',
        'comment_by',
        'comment_file'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'comment_by');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
