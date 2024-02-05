<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'priority',
        'project_id'
    ];

    /**
     * Each task belongs to a project
     *
     * @return void
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
