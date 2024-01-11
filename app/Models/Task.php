<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Subtask;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description', 'status', 'image'];

    public function subtask()
    {
        return $this->hasMany(Subtask::class);
    }

    protected static function booted () {
        static::deleting(function(Task $task) {
             $task->subtask()->delete();
        });
    }
}
