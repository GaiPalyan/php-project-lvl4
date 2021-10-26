<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description',
        'created_by_id', 'status_id',
        'assigned_to_id'
    ];

    public function status()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function assign()
    {
        return $this->belongsTo(User::class);
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }
}
